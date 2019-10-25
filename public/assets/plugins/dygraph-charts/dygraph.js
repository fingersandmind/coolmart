// Copyright 2006 Dan Vanderkam (danvdk@gmail.com)
// All Rights Reserved.

/**
 * @fileoverview Creates an interactive, zoomable graph based on a CSV file or
 * string. DateGraph can handle multiple series with or without error bars. The
 * date/value ranges will be automatically set. DateGraph uses the
 * &lt;canvas&gt; tag, so it only works in FF1.5+.
 * @author danvdk@gmail.com (Dan Vanderkam)

  Usage:
   <div id="graphdiv" style="width:800px; height:500px;"></div>
   <script type="text/javascript">
     new DateGraph(document.getElementById("graphdiv"),
                   "datafile.csv",
                     ["Series 1", "Series 2"],
                     { }); // options
   </script>

 The CSV file is of the form

   YYYYMMDD,A1,B1,C1
   YYYYMMDD,A2,B2,C2

 If null is passed as the third parameter (series names), then the first line
 of the CSV file is assumed to contain names for each series.

 If the 'errorBars' option is set in the constructor, the input should be of
 the form

   YYYYMMDD,A1,sigmaA1,B1,sigmaB1,...
   YYYYMMDD,A2,sigmaA2,B2,sigmaB2,...

 If the 'fractions' option is set, the input should be of the form:

   YYYYMMDD,A1/B1,A2/B2,...
   YYYYMMDD,A1/B1,A2/B2,...

 And error bars will be calculated automatically using a binomial distribution.

 For further documentation and examples, see http://www/~danvk/dg/

 */

/**
 * An interactive, zoomable graph
 * @param {String | Function} file A file containing CSV data or a function that
 * returns this data. The expected format for each line is
 * YYYYMMDD,val1,val2,... or, if attrs.errorBars is set,
 * YYYYMMDD,val1,stddev1,val2,stddev2,...
 * @param {Array.<String>} labels Labels for the data series
 * @param {Object} attrs Various other attributes, e.g. errorBars determines
 * whether the input data contains error ranges.
 */
DateGraph = function(div, file, labels, attrs) {
  if (arguments.length > 0)
    this.__init__(div, file, labels, attrs);
};

DateGraph.NAME = "DateGraph";
DateGraph.VERSION = "1.1";
DateGraph.__repr__ = function() {
  return "[" + this.NAME + " " + this.VERSION + "]";
};
DateGraph.toString = function() {
  return this.__repr__();
};

// Various default values
DateGraph.DEFAULT_ROLL_PERIOD = 1;
DateGraph.DEFAULT_WIDTH = 480;
DateGraph.DEFAULT_HEIGHT = 320;
DateGraph.DEFAULT_STROKE_WIDTH = 1.0;
DateGraph.AXIS_LINE_WIDTH = 0.3;

// Default attribute values.
DateGraph.DEFAULT_ATTRS = {
  highlightCircleSize: 3,
  pixelsPerXLabel: 60,
  pixelsPerYLabel: 30,
  labelsDivWidth: 250,
  labelsDivStyles: {
    // TODO(danvk): move defaults from createStatusMessage_ here.
  }

  // TODO(danvk): default padding
};

/**
 * Initializes the DateGraph. This creates a new DIV and constructs the PlotKit
 * and interaction &lt;canvas&gt; inside of it. See the constructor for details
 * on the parameters.
 * @param {String | Function} file Source data
 * @param {Array.<String>} labels Names of the data series
 * @param {Object} attrs Miscellaneous other options
 * @private
 */
DateGraph.prototype.__init__ = function(div, file, labels, attrs) {
  // Copy the important bits into the object
  // TODO(danvk): most of these should just stay in the attrs_ dictionary.
  this.maindiv_ = div;
  this.labels_ = labels;
  this.file_ = file;
  this.rollPeriod_ = attrs.rollPeriod || DateGraph.DEFAULT_ROLL_PERIOD;
  this.previousVerticalX_ = -1;
  this.width_ = MochiKit.Style.getElementDimensions(div).w;
  this.height_ = parseInt(div.style.height, 10);
  this.errorBars_ = attrs.errorBars || false;
  this.dataHasErrorBars_ = attrs.dataHasErrorBars || this.errorBars_;
  this.stackedGraph_ = attrs.stackedGraph || false;
  this.fractions_ = attrs.fractions || false;
  this.strokeWidth_ = attrs.strokeWidth || DateGraph.DEFAULT_STROKE_WIDTH;
  this.dateWindow_ = attrs.dateWindow || null;
  this.highlightClosestPoint_ = attrs.highlightClosestPoint || false;
  this.valueRange_ = attrs.valueRange || null;
  this.labelsSeparateLines = attrs.labelsSeparateLines || false;
  this.labelsDiv_ = attrs.labelsDiv || null;
  this.labelsKMB_ = attrs.labelsKMB || false;
  this.xValueParser_ = attrs.xValueParser || DateGraph.prototype.dateParser;
  this.xValueFormatter_ = attrs.xValueFormatter ||
      DateGraph.prototype.dateString_;
  this.xTicker_ = attrs.xTicker || DateGraph.prototype.dateTicker;
  this.sigma_ = attrs.sigma || 2.0;
  this.wilsonInterval_ = attrs.wilsonInterval || true;
  this.customBars_ = attrs.customBars || false;
  this.colorsChanged_ = false;

  this.attrs_ = {};

  attrs.shouldFill = attrs.shouldFill || this.stackedGraph_;

  MochiKit.Base.update(this.attrs_, DateGraph.DEFAULT_ATTRS);
  MochiKit.Base.update(this.attrs_, attrs);

  if (typeof this.attrs_.pixelsPerXLabel == 'undefined') {
    this.attrs_.pixelsPerXLabel = 60;
  }

  // Make a note of whether labels will be pulled from the CSV file.
  this.labelsFromCSV_ = (this.labels_ == null);
  if (this.labels_ == null)
    this.labels_ = [];

  // Prototype of the callback is "void clickCallback(event, date)"
  this.clickCallback_ = attrs.clickCallback || null;

  // Prototype of zoom callback is "void dragCallback(minDate, maxDate)"
  this.zoomCallback_ = attrs.zoomCallback || null;

  // Create the containing DIV and other interactive elements
  this.createInterface_();

  // Create the PlotKit grapher
  this.layoutOptions_ = { 'errorBars': (this.errorBars_ || this.customBars_),
                          'dataHasErrorBars': this.dataHasErrorBars_,
                          'stackedGraph': this.stackedGraph_,
                          'xOriginIsZero': false,
                          'yTickPrecision': 5 };
  MochiKit.Base.update(this.layoutOptions_, attrs);
  this.setColors_(attrs);

  this.layout_ = new DateGraphLayout(this.layoutOptions_);

  this.renderOptions_ = { colorScheme: this.colors_,
                          strokeColor: null,
                          strokeWidth: this.strokeWidth_,
                          axisLabelFontSize: 12,
                          axisLineWidth: DateGraph.AXIS_LINE_WIDTH };
  MochiKit.Base.update(this.renderOptions_, attrs);
  this.plotter_ = new DateGraphCanvasRenderer(this.hidden_, this.layout_,
                                              this.renderOptions_);

  this.createStatusMessage_();
  this.createRollInterface_();
  this.createDragInterface_();

  // connect(window, 'onload', this, function(e) { this.start_(); });
  this.start_();
};

/**
 * Returns the current rolling period, as set by the user or an option.
 * @return {Number} The number of days in the rolling window
 */
DateGraph.prototype.rollPeriod = function() {
  return this.rollPeriod_;
}

/**
 * Generates interface elements for the DateGraph: a containing div, a div to
 * display the current point, and a textbox to adjust the rolling average
 * period.
 * @private
 */
DateGraph.prototype.createInterface_ = function() {
  // Create the all-enclosing graph div
  var enclosing = this.maindiv_;

  this.graphDiv = MochiKit.DOM.DIV( { style: { 'width': this.width_ + "px",
                                                'height': this.height_ + "px"
                                                 }});
  appendChildNodes(enclosing, this.graphDiv);

  // Create the canvas to store
  var canvas = MochiKit.DOM.CANVAS;
  this.canvas_ = canvas( { style: { 'position': 'absolute'},
                          width: this.width_,
                          height: this.height_});
  appendChildNodes(this.graphDiv, this.canvas_);

  this.hidden_ = this.createPlotKitCanvas_(this.canvas_);
  connect(this.canvas_, 'onmousemove', this, function(e) { this.mouseMove_(e) });
  connect(this.canvas_, 'onmouseout', this, function(e) { this.mouseOut_(e) });
}

/**
 * Creates the canvas containing the PlotKit graph. Only plotkit ever draws on
 * this particular canvas. All DateGraph work is done on this.canvas_.
 * @param {Object} canvas The DateGraph canvas to over which to overlay the plot
 * @return {Object} The newly-created canvas
 * @private
 */
DateGraph.prototype.createPlotKitCanvas_ = function(canvas) {
  var h = document.createElement("canvas");
  h.style.position = "absolute";
  h.style.top = canvas.style.top;
  h.style.left = canvas.style.left;
  h.width = this.width_;
  h.height = this.height_;
  MochiKit.DOM.insertSiblingNodesBefore(canvas, h);
  return h;
};

/**
 * Generate a set of distinct colors for the data series. This is done with a
 * color wheel. Saturation/Value are customizable, and the hue is
 * equally-spaced around the color wheel. If a custom set of colors is
 * specified, that is used instead.
 * @param {Object} attrs Various attributes, e.g. saturation and value
 * @private
 */
DateGraph.prototype.setColors_ = function(attrs) {
  var num = this.labels_.length;
  this.colors_ = [];
  if (!attrs.colors) {
    var sat = attrs.colorSaturation || 1.0;
    var val = attrs.colorValue || 0.5;
    for (var i = 1; i <= num; i++) {
      var hue = (1.0*i/(1+num));
      this.colors_.push( MochiKit.Color.Color.fromHSV(hue, sat, val) );
    }
  } else {
    for (var i = 0; i < num; i++) {
      var colorStr = attrs.colors[i % attrs.colors.length];
      this.colors_.push( MochiKit.Color.Color.fromString(colorStr) );
    }
  }
}

/**
 * Create the div that contains information on the selected point(s)
 * This goes in the top right of the canvas, unless an external div has already
 * been specified.
 * @private
 */
DateGraph.prototype.createStatusMessage_ = function(){
  if (!this.labelsDiv_) {
    var divWidth = this.attrs_.labelsDivWidth;
    var messagestyle = { "style": {
      "position": "absolute",
      "fontSize": "12px",
      "zIndex": 10,
      "width": divWidth + "px",
      "top": "0px",
      "left": this.width_ - divWidth + "px",
      "background": "white",
      "textAlign": "left",
      "overflow": "hidden"}};
    MochiKit.Base.update(messagestyle["style"], this.attrs_.labelsDivStyles);
    this.labelsDiv_ = MochiKit.DOM.DIV(messagestyle);
    MochiKit.DOM.appendChildNodes(this.graphDiv, this.labelsDiv_);
  }
};

/**
 * Create the text box to adjust the averaging period
 * @return {Object} The newly-created text box
 * @private
 */
DateGraph.prototype.createRollInterface_ = function() {
  var padding = this.plotter_.options.padding;
  if (typeof this.attrs_.showRoller == 'undefined') {
    this.attrs_.showRoller = false;
  }
  var display = this.attrs_.showRoller ? "block" : "none";
  var textAttr = { "type": "text",
                   "size": "2",
                   "value": this.rollPeriod_,
                   "style": { "position": "absolute",
                              "zIndex": 10,
                              "top": (this.height_ - 25 - padding.bottom) + "px",
                              "left": (padding.left+1) + "px",
                              "display": display }
                  };
  var roller = MochiKit.DOM.INPUT(textAttr);
  var pa = this.graphDiv;
  MochiKit.DOM.appendChildNodes(pa, roller);
  connect(roller, 'onchange', this,
          function() { this.adjustRoll(roller.value); });
  return roller;
}

/**
 * Set up all the mouse handlers needed to capture dragging behavior for zoom
 * events. Uses MochiKit.Signal to attach all the event handlers.
 * @private
 */
DateGraph.prototype.createDragInterface_ = function() {
  var self = this;

  // Tracks whether the mouse is down right now
  var mouseDown = false;
  var dragStartX = null;
  var dragStartY = null;
  var dragEndX = null;
  var dragEndY = null;
  var prevEndX = null;

  // Utility function to convert page-wide coordinates to canvas coords
  var px = 0;
  var py = 0;
  var getX = function(e) { return e.mouse().page.x - px };
  var getY = function(e) { return e.mouse().page.y - py };

  // Draw zoom rectangles when the mouse is down and the user moves around
  connect(this.canvas_, 'onmousemove', function(event) {
    if (mouseDown) {
      dragEndX = getX(event);
      dragEndY = getY(event);

      self.drawZoomRect_(dragStartX, dragEndX, prevEndX);
      prevEndX = dragEndX;
    }
  });

  // Track the beginning of drag events
  connect(this.canvas_, 'onmousedown', function(event) {
    mouseDown = true;
    px = PlotKit.Base.findPosX(self.canvas_);
    py = PlotKit.Base.findPosY(self.canvas_);
    dragStartX = getX(event);
    dragStartY = getY(event);
  });

  // If the user releases the mouse button during a drag, but not over the
  // canvas, then it doesn't count as a zooming action.
  connect(document, 'onmouseup', this, function(event) {
    if (mouseDown) {
      mouseDown = false;
      dragStartX = null;
      dragStartY = null;
    }
  });

  // Temporarily cancel the dragging event when the mouse leaves the graph
  connect(this.canvas_, 'onmouseout', this, function(event) {
    if (mouseDown) {
      dragEndX = null;
      dragEndY = null;
    }
  });

  // If the mouse is released on the canvas during a drag event, then it's a
  // zoom. Only do the zoom if it's over a large enough area (>= 10 pixels)
  connect(this.canvas_, 'onmouseup', this, function(event) {
    if (mouseDown) {
      mouseDown = false;
      dragEndX = getX(event);
      dragEndY = getY(event);
      var regionWidth = Math.abs(dragEndX - dragStartX);
      var regionHeight = Math.abs(dragEndY - dragStartY);

      if (regionWidth < 2 && regionHeight < 2 &&
          self.clickCallback_ != null &&
          self.lastx_ != undefined) {
        self.clickCallback_(event, new Date(self.lastx_));
      }

      if (regionWidth >= 10) {
        self.doZoom_(Math.min(dragStartX, dragEndX),
                     Math.max(dragStartX, dragEndX));
      } else {
        self.canvas_.getContext("2d").clearRect(0, 0,
                                           self.canvas_.width,
                                           self.canvas_.height);
      }

      dragStartX = null;
      dragStartY = null;
    }
  });

  // Double-clicking zooms back out
  connect(this.canvas_, 'ondblclick', this, function(event) {
    self.dateWindow_ = null;
    self.drawGraph_(self.rawData_);
    var minDate = self.rawData_[0][0];
    var maxDate = self.rawData_[self.rawData_.length - 1][0];
    if (self.zoomCallback_) {
      self.zoomCallback_(minDate, maxDate);
    }
  });
};

/**
 * Draw a gray zoom rectangle over the desired area of the canvas. Also clears
 * up any previous zoom rectangles that were drawn. This could be optimized to
 * avoid extra redrawing, but it's tricky to avoid interactions with the status
 * dots.
 * @param {Number} startX The X position where the drag started, in canvas
 * coordinates.
 * @param {Number} endX The current X position of the drag, in canvas coords.
 * @param {Number} prevEndX The value of endX on the previous call to this
 * function. Used to avoid excess redrawing
 * @private
 */
DateGraph.prototype.drawZoomRect_ = function(startX, endX, prevEndX) {
  var ctx = this.canvas_.getContext("2d");

  // Clean up from the previous rect if necessary
  if (prevEndX) {
    ctx.clearRect(Math.min(startX, prevEndX), 0,
                  Math.abs(startX - prevEndX), this.height_);
  }

  // Draw a light-grey rectangle to show the new viewing area
  if (endX && startX) {
    ctx.fillStyle = "rgba(128,128,128,0.33)";
    ctx.fillRect(Math.min(startX, endX), 0,
                 Math.abs(endX - startX), this.height_);
  }
};

/**
 * Zoom to something containing [lowX, highX]. These are pixel coordinates
 * in the canvas. The exact zoom window may be slightly larger if there are no
 * data points near lowX or highX. This function redraws the graph.
 * @param {Number} lowX The leftmost pixel value that should be visible.
 * @param {Number} highX The rightmost pixel value that should be visible.
 * @private
 */
DateGraph.prototype.doZoom_ = function(lowX, highX) {
  // Find the earliest and latest dates contained in this canvasx range.
  var points = this.layout_.points;
  var minDate = null;
  var maxDate = null;
  // Find the nearest [minDate, maxDate] that contains [lowX, highX]
  for (var i = 0; i < points.length; i++) {
    var cx = points[i].canvasx;
    var x = points[i].xval;
    if (cx < lowX  && (minDate == null || x > minDate)) minDate = x;
    if (cx > highX && (maxDate == null || x < maxDate)) maxDate = x;
  }
  // Use the extremes if either is missing
  if (minDate == null) minDate = points[0].xval;
  if (maxDate == null) maxDate = points[points.length-1].xval;

  this.dateWindow_ = [minDate, maxDate];
  this.drawGraph_(this.rawData_);
  if (this.zoomCallback_) {
    this.zoomCallback_(minDate, maxDate);
  }
};

/**
 * When the mouse moves in the canvas, display information about a nearby data
 * point and draw dots over those points in the data series. This function
 * takes care of cleanup of previously-drawn dots.
 * @param {Object} event The mousemove event from the browser.
 * @private
 */
DateGraph.prototype.mouseMove_ = function(event) {
  var canvasx = event.mouse().page.x - PlotKit.Base.findPosX(this.hidden_);
  var canvasy = event.mouse().page.y - PlotKit.Base.findPosY(this.hidden_);
  var points = this.layout_.points;

  var lastx = -1;
  var lasty = -1;

  // Loop through all the points and find the date nearest to our current
  // location.
  var xminDist = 1e+100;
  var idx = -1;
  for (var i = 0; i < points.length; i++) {
    var xdist = Math.abs(points[i].canvasx - canvasx);
    if (xdist > xminDist) break;
    xminDist = xdist;
    idx = i;
  }
  if (idx >= 0) lastx = points[idx].xval;
  // Check that you can really highlight the last day's data
  if (canvasx > points[points.length-1].canvasx)
    lastx = points[points.length-1].xval;

  // Extract the points we've selected
  var selPoints = [];
  for (var i = 0; i < points.length; i++) {
    if (points[i].xval == lastx) {
      selPoints.push(points[i]);
    }
  }

  var closestPoint = false;
  var yminDist = 1e+100;
  // Find the closest point
  if (this.highlightClosestPoint_) {
    for(var x = 0; x < selPoints.length; x++) {
      var ydist = Math.abs(selPoints[x].canvasy - canvasy);
      if (ydist < yminDist) {
        yminDist = ydist;
        closestPoint = selPoints[x];
      }
    }
  }

  // Clear the previously drawn vertical, if there is one
  var circleSize = this.attrs_.highlightCircleSize;
  var ctx = this.canvas_.getContext("2d");
  if (this.previousVerticalX_ >= 0) {
    var px = this.previousVerticalX_;
    ctx.clearRect(px - circleSize - 2, 0, 2 * circleSize + 5, this.height_);
  }

  if (selPoints.length > 0) {
    var canvasx = selPoints[0].canvasx;

    // Set the status message to indicate the selected point(s)
    var replace = this.xValueFormatter_(lastx) + ":";
    var clen = this.colors_.length;
    for (var i = 0; i < selPoints.length; i++) {
      if (this.labelsSeparateLines) {
        replace += "<br/>";
      }
      var point = selPoints[i];
      if(point == closestPoint) {
        replace += "<span class='highlight'>";
      }
      replace += " <b><font color='" + this.colors_[i%clen].toHexString() + "'>"
              + point.name + "</font></b>:"
              + this.round_(point.yval, 5);
      if(point == closestPoint) {
        replace += "</span>";
      }
    }
    this.labelsDiv_.innerHTML = replace;

    // Save last x position for callbacks.
    this.lastx_ = lastx;

    // Draw colored circles over the center of each selected point
    ctx.save();
    for (var i = 0; i < selPoints.length; i++) {
      if(selPoints[i] == closestPoint) {
        ctx.beginPath();
        ctx.fillStyle = "rgb(255, 0, 0)";
        ctx.arc(canvasx, selPoints[i%clen].canvasy, circleSize + 2, 0, 360, false);
        ctx.fill();
      }
      ctx.beginPath();
      ctx.fillStyle = this.colors_[i%clen].toRGBString();
      ctx.arc(canvasx, selPoints[i%clen].canvasy, circleSize, 0, 360, false);
      ctx.fill();
    }
    ctx.restore();

    this.previousVerticalX_ = canvasx;
  }
};

/**
 * The mouse has left the canvas. Clear out whatever artifacts remain
 * @param {Object} event the mouseout event from the browser.
 * @private
 */
DateGraph.prototype.mouseOut_ = function(event) {
  // Get rid of the overlay data
  var ctx = this.canvas_.getContext("2d");
  ctx.clearRect(0, 0, this.width_, this.height_);
  this.labelsDiv_.innerHTML = "";
};

DateGraph.zeropad = function(x) {
  if (x < 10) return "0" + x; else return "" + x;
}

/**
 * Return a string version of the hours, minutes and seconds portion of a date.
 * @param {Number} date The JavaScript date (ms since epoch)
 * @return {String} A time of the form "HH:MM:SS"
 * @private
 */
DateGraph.prototype.hmsString_ = function(date) {
  var zeropad = DateGraph.zeropad;
  var d = new Date(date);
  if (d.getSeconds()) {
    return zeropad(d.getHours()) + ":" +
           zeropad(d.getMinutes()) + ":" +
           zeropad(d.getSeconds());
  } else if (d.getMinutes()) {
    return zeropad(d.getHours()) + ":" + zeropad(d.getMinutes());
  } else {
    return zeropad(d.getHours());
  }
}

/**
 * Convert a JS date (millis since epoch) to YYYY/MM/DD
 * @param {Number} date The JavaScript date (ms since epoch)
 * @return {String} A date of the form "YYYY/MM/DD"
 * @private
 */
DateGraph.prototype.dateString_ = function(date) {
  var zeropad = DateGraph.zeropad;
  var d = new Date(date);

  // Get the year:
  var year = "" + d.getFullYear();
  // Get a 0 padded month string
  var month = zeropad(d.getMonth() + 1);  //months are 0-offset, sigh
  // Get a 0 padded day string
  var day = zeropad(d.getDate());

  var ret = "";
  var frac = d.getHours() * 3600 + d.getMinutes() * 60 + d.getSeconds();
  if (frac) ret = " " + this.hmsString_(date);

  return year + "/" + month + "/" + day + ret;
};

/**
 * Round a number to the specified number of digits past the decimal point.
 * @param {Number} num The number to round
 * @param {Number} places The number of decimals to which to round
 * @return {Number} The rounded number
 * @private
 */
DateGraph.prototype.round_ = function(num, places) {
  var shift = Math.pow(10, places);
  return Math.round(num * shift)/shift;
};

/**
 * Fires when there's data available to be graphed.
 * @param {String} data Raw CSV data to be plotted
 * @private
 */
DateGraph.prototype.loadedEvent_ = function(data) {
  if (typeof(jQuery) != "undefined")
    jQuery(document).trigger('graph.loaded');
  this.rawData_ = this.parseCSV_(data);
  this.drawGraph_(this.rawData_);
};

DateGraph.prototype.months =  ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                               "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
DateGraph.prototype.quarters = ["Jan", "Apr", "Jul", "Oct"];

/**
 * Add ticks on the x-axis representing years, months, quarters, weeks, or days
 * @private
 */
DateGraph.prototype.addXTicks_ = function() {
  // Determine the correct ticks scale on the x-axis: quarterly, monthly, ...
  var startDate, endDate;
  if (this.dateWindow_) {
    startDate = this.dateWindow_[0];
    endDate = this.dateWindow_[1];
  } else {
    startDate = this.rawData_[0][0];
    endDate   = this.rawData_[this.rawData_.length - 1][0];
  }

  var xTicks = this.xTicker_(startDate, endDate);
  this.layout_.updateOptions({xTicks: xTicks});
};

// Time granularity enumeration
DateGraph.SECONDLY = 0;
DateGraph.MINUTELY = 1;
DateGraph.HOURLY = 2;
DateGraph.DAILY = 3;
DateGraph.WEEKLY = 4;
DateGraph.MONTHLY = 5;
DateGraph.QUARTERLY = 6;
DateGraph.BIANNUAL = 7;
DateGraph.ANNUAL = 8;
DateGraph.DECADAL = 9;
DateGraph.NUM_GRANULARITIES = 10;

DateGraph.SHORT_SPACINGS = [];
DateGraph.SHORT_SPACINGS[DateGraph.SECONDLY] = 1000 * 1;
DateGraph.SHORT_SPACINGS[DateGraph.MINUTELY] = 1000 * 60;
DateGraph.SHORT_SPACINGS[DateGraph.HOURLY]   = 1000 * 3600;
DateGraph.SHORT_SPACINGS[DateGraph.DAILY]    = 1000 * 86400;
DateGraph.SHORT_SPACINGS[DateGraph.WEEKLY]   = 1000 * 604800;

// NumXTicks()
//
//   If we used this time granularity, how many ticks would there be?
//   This is only an approximation, but it's generally good enough.
//
DateGraph.prototype.NumXTicks = function(start_time, end_time, granularity) {
  if (granularity < DateGraph.MONTHLY) {
    // Generate one tick mark for every fixed interval of time.
    var spacing = DateGraph.SHORT_SPACINGS[granularity];
    return Math.floor(0.5 + 1.0 * (end_time - start_time) / spacing);
  } else {
    var year_mod = 1;  // e.g. to only print one point every 10 years.
    var num_months = 12;
    if (granularity == DateGraph.QUARTERLY) num_months = 3;
    if (granularity == DateGraph.BIANNUAL) num_months = 2;
    if (granularity == DateGraph.ANNUAL) num_months = 1;
    if (granularity == DateGraph.DECADAL) { num_months = 1; year_mod = 10; }

    var msInYear = 365.2524 * 24 * 3600 * 1000;
    var num_years = 1.0 * (end_time - start_time) / msInYear;
    return Math.floor(0.5 + 1.0 * num_years * num_months / year_mod);
  }
};

// GetXAxis()
//
//   Construct an x-axis of nicely-formatted times on meaningful boundaries
//   (e.g. 'Jan 09' rather than 'Jan 22, 2009').
//
//   Returns an array containing {v: millis, label: label} dictionaries.
//
DateGraph.prototype.GetXAxis = function(start_time, end_time, granularity) {
  var ticks = [];
  if (granularity < DateGraph.MONTHLY) {
    // Generate one tick mark for every fixed interval of time.
    var spacing = DateGraph.SHORT_SPACINGS[granularity];
    var format = '%d%b';  // e.g. "1 Jan"
    for (var t = start_time; t <= end_time; t += spacing) {
      var d = new Date(t);
      var frac = d.getHours() * 3600 + d.getMinutes() * 60 + d.getSeconds();
      if (frac == 0 || granularity >= DateGraph.DAILY) {
        // the extra hour covers DST problems.
        ticks.push({ v:t, label: new Date(t + 3600*1000).strftime(format) });
      } else {
        ticks.push({ v:t, label: this.hmsString_(t) });
      }
    }
  } else {
    // Display a tick mark on the first of a set of months of each year.
    // Years get a tick mark iff y % year_mod == 0. This is useful for
    // displaying a tick mark once every 10 years, say, on long time scales.
    var months;
    var year_mod = 1;  // e.g. to only print one point every 10 years.

    // TODO(danvk): use CachingRoundTime where appropriate to get boundaries.
    if (granularity == DateGraph.MONTHLY) {
      months = [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 ];
    } else if (granularity == DateGraph.QUARTERLY) {
      months = [ 0, 3, 6, 9 ];
    } else if (granularity == DateGraph.BIANNUAL) {
      months = [ 0, 6 ];
    } else if (granularity == DateGraph.ANNUAL) {
      months = [ 0 ];
    } else if (granularity == DateGraph.DECADAL) {
      months = [ 0 ];
      year_mod = 10;
    }

    var start_year = new Date(start_time).getFullYear();
    var end_year   = new Date(end_time).getFullYear();
    var zeropad = DateGraph.zeropad;
    for (var i = start_year; i <= end_year; i++) {
      if (i % year_mod != 0) continue;
      for (var j = 0; j < months.length; j++) {
        var date_str = i + "/" + zeropad(1 + months[j]) + "/01";
        var t = Date.parse(date_str);
        if (t < start_time || t > end_time) continue;
        ticks.push({ v:t, label: new Date(t).strftime('%b %y') });
      }
    }
  }

  return ticks;
};


/**
 * Add ticks to the x-axis based on a date range.
 * @param {Number} startDate Start of the date window (millis since epoch)
 * @param {Number} endDate End of the date window (millis since epoch)
 * @return {Array.<Object>} Array of {label, value} tuples.
 * @public
 */
DateGraph.prototype.dateTicker = function(startDate, endDate) {
  var chosen = -1;
  for (var i = 0; i < DateGraph.NUM_GRANULARITIES; i++) {
    var num_ticks = this.NumXTicks(startDate, endDate, i);
    if (this.width_ / num_ticks >= this.attrs_.pixelsPerXLabel) {
      chosen = i;
      break;
    }
  }

  if (chosen >= 0) {
    return this.GetXAxis(startDate, endDate, chosen);
  } else {
    // TODO(danvk): signal error.
  }
};

/**
 * Add ticks when the x axis has numbers on it (instead of dates)
 * @param {Number} startDate Start of the date window (millis since epoch)
 * @param {Number} endDate End of the date window (millis since epoch)
 * @return {Array.<Object>} Array of {label, value} tuples.
 * @public
 */
DateGraph.prototype.numericTicks = function(minV, maxV) {
  // Basic idea:
  // Try labels every 1, 2, 5, 10, 20, 50, 100, etc.
  // Calculate the resulting tick spacing (i.e. this.height_ / nTicks).
  // The first spacing greater than this.attrs_.pixelsPerYLabel is what we use.
  var mults = [1, 2, 5];
  var scale, low_val, high_val, nTicks;
  for (var i = -10; i < 50; i++) {
    var base_scale = Math.pow(10, i);
    for (var j = 0; j < mults.length; j++) {
      scale = base_scale * mults[j];
      low_val = Math.floor(minV / scale) * scale;
      high_val = Math.ceil(maxV / scale) * scale;
      nTicks = (high_val - low_val) / scale;
      var spacing = this.height_ / nTicks;
      // wish I could break out of both loops at once...
      if (spacing > this.attrs_.pixelsPerYLabel) break;
    }
    if (spacing > this.attrs_.pixelsPerYLabel) break;
  }

  // Construct labels for the ticks
  var ticks = [];
  for (var i = 0; i < nTicks; i++) {
    var tickV = low_val + i * scale;
    var label = this.round_(tickV, 5);
    if (this.labelsKMB_) {
      var k = 1000;
      if (tickV >= k*k*k) {
        label = this.round_(tickV/(k*k*k), 1) + "B";
      } else if (tickV >= k*k) {
        label = this.round_(tickV/(k*k), 1) + "M";
      } else if (tickV >= k) {
        label = this.round_(tickV/k, 1) + "K";
      }
    }
    ticks.push( {label: label, v: tickV} );
  }
  return ticks;
};

/**
 * Adds appropriate ticks on the y-axis
 * @param {Number} minY The minimum Y value in the data set
 * @param {Number} maxY The maximum Y value in the data set
 * @private
 */
DateGraph.prototype.addYTicks_ = function(minY, maxY) {
  // Set the number of ticks so that the labels are human-friendly.
  var ticks = this.numericTicks(minY, maxY);
  this.layout_.updateOptions( { yAxis: [minY, maxY],
                                yTicks: ticks } );
};

/**
 * Update the graph with new data. Data is in the format
 * [ [date1, val1, val2, ...], [date2, val1, val2, ...] if errorBars=false
 * or, if errorBars=true,
 * [ [date1, [val1,stddev1], [val2,stddev2], ...], [date2, ...], ...]
 * @param {Array.<Object>} data The data (see above)
 * @private
 */
DateGraph.prototype.drawGraph_ = function(data) {
  var maxY = null;
  this.layout_.removeAllDatasets();
  // Loop over all fields in the dataset
  var sums = [];
  var datasets = [];
  for (var i = 1; i < data[0].length; i++) {
    var series = [];
    for (var j = 0; j < data.length; j++) {
      var date = data[j][0];
      series[j] = [date, data[j][i]];
    }
    series = this.rollingAverage(series, this.rollPeriod_);

    // Prune down to the desired range, if necessary (for zooming)
    var bars = this.dataHasErrorBars_;
    if (this.dateWindow_) {
      var low = this.dateWindow_[0];
      var high= this.dateWindow_[1];
      var pruned = [];
      for (var k = 0; k < series.length; k++) {
        if (series[k][0] >= low && series[k][0] <= high) {
          pruned.push(series[k]);
          var y = bars ? series[k][1][0] : series[k][1];
          if (maxY == null || y > maxY) maxY = y;
        }
      }
      series = pruned;
    } else {
      for (var j = 0; j < series.length; j++) {
        var y = bars ? series[j][1][0] : series[j][1];
        if (maxY == null || y > maxY) {
          maxY = this.errorBars_ ? y + series[j][1][1] : y;
        }
      }
    }

    if (bars || this.stackedGraph_) {
      // If it is either of these we need to run through the series
      var vals = [];
      for (var j=0; j<series.length; j++) {
        var y;
        if (bars) {
          y = series[j][1][0];
        } else {
          y = series[j][1];
        }
        if (this.stackedGraph_) {
          if (sums[series[j][0]] === undefined) {
            sums[series[j][0]] = 0;
          }
          var old_y = y;
          y += sums[series[j][0]];
          sums[series[j][0]] += old_y;
          if (maxY == null || y > maxY) 
            maxY = y;
        }
        if (bars) {
          vals[j] = [series[j][0],
                     y, series[j][1][1], series[j][1][2]];
        } else {
          vals[j] = [series[j][0], y];
        }
      }
      if (this.stackedGraph_) {
        datasets.push([this.labels_[i - 1], vals]);
      } else {
        this.layout_.addDataset(this.labels_[i - 1], vals);
      }
    } else {
      this.layout_.addDataset(this.labels_[i - 1], series);
    }
    /*
      if (this.stackedGraph_) {
        if (sums[series[j][0]] === undefined) 
          sums[series[j][0]] = 0;
        y = series[j][1] + sums[series[j][0]];
        vals[j] = [series[j][0], (y)];
        if (maxY == null || y > maxY) maxY = y;
        sums[series[j][0]] = sums[series[j][0]] + series[j][1];
      }

      datasets.push([this.labels_[i - 1], vals]);
    } else if (bars) {
      console.log("Bars");
      var vals = [];
      for (var j=0; j<series.length; j++)
        vals[j] = [series[j][0],
                   series[j][1][0], series[j][1][1], series[j][1][2]];
      this.layout_.addDataset(this.labels_[i - 1], vals);
    } else {
        this.layout_.addDataset(this.labels_[i - 1], series);
      }
    }
    */
  }
  if (datasets.length != 0) {
    if(!this.colorsChanged_) {
      this.renderOptions_.colorScheme.reverse();
      this.colorsChanged_ = true;
    }
    for (var i = (datasets.length - 1); i >= 0; i--) {
      this.layout_.addDataset(datasets[i][0], datasets[i][1]);
    }
  }

  // Use some heuristics to come up with a good maxY value, unless it's been
  // set explicitly by the user.
  if (this.valueRange_ != null) {
    this.addYTicks_(this.valueRange_[0], this.valueRange_[1]);
  } else {
    // Add some padding and round up to an integer to be human-friendly.
    maxY *= 1.1;
    if (maxY <= 0.0) maxY = 1.0;
    this.addYTicks_(0, maxY);
  }

  this.addXTicks_();

  // Tell PlotKit to use this new data and render itself
  this.layout_.evaluateWithError();
  this.plotter_.clear();
  this.plotter_.render();
  this.canvas_.getContext('2d').clearRect(0, 0,
                                         this.canvas_.width, this.canvas_.height);
};

/**
 * Calculates the rolling average of a data set.
 * If originalData is [label, val], rolls the average of those.
 * If originalData is [label, [, it's interpreted as [value, stddev]
 *   and the roll is returned in the same form, with appropriately reduced
 *   stddev for each value.
 * Note that this is where fractional input (i.e. '5/10') is converted into
 *   decimal values.
 * @param {Array} originalData The data in the appropriate format (see above)
 * @param {Number} rollPeriod The number of days over which to average the data
 */
DateGraph.prototype.rollingAverage = function(originalData, rollPeriod) {
  if (originalData.length < 2)
    return originalData;
  var rollPeriod = Math.min(rollPeriod, originalData.length - 1);
  var rollingData = [];
  var sigma = this.sigma_;

  if (this.fractions_) {
    var num = 0;
    var den = 0;  // numerator/denominator
    var mult = 100.0;
    for (var i = 0; i < originalData.length; i++) {
      num += originalData[i][1][0];
      den += originalData[i][1][1];
      if (i - rollPeriod >= 0) {
        num -= originalData[i - rollPeriod][1][0];
        den -= originalData[i - rollPeriod][1][1];
      }

      var date = originalData[i][0];
      var value = den ? num / den : 0.0;
      if (this.errorBars_) {
        if (this.wilsonInterval_) {
          // For more details on this confidence interval, see:
          // http://en.wikipedia.org/wiki/Binomial_confidence_interval
          if (den) {
            var p = value < 0 ? 0 : value, n = den;
            var pm = sigma * Math.sqrt(p*(1-p)/n + sigma*sigma/(4*n*n));
            var denom = 1 + sigma * sigma / den;
            var low  = (p + sigma * sigma / (2 * den) - pm) / denom;
            var high = (p + sigma * sigma / (2 * den) + pm) / denom;
            rollingData[i] = [date,
                              [p * mult, (p - low) * mult, (high - p) * mult]];
          } else {
            rollingData[i] = [date, [0, 0, 0]];
          }
        } else {
          var stddev = den ? sigma * Math.sqrt(value * (1 - value) / den) : 1.0;
          rollingData[i] = [date, [mult * value, mult * stddev, mult * stddev]];
        }
      } else {
        rollingData[i] = [date, mult * value];
      }
    }
  } else if (this.customBars_) {
    var low = 0;
    var mid = 0;
    var high = 0;
    var count = 0;
    for (var i = 0; i < originalData.length; i++) {
      var data = originalData[i][1];
      var y = data[1];
      rollingData[i] = [originalData[i][0], [y, y - data[0], data[2] - y]];

      low += data[0];
      mid += y;
      high += data[2];
      count += 1;
      if (i - rollPeriod >= 0) {
        var prev = originalData[i - rollPeriod];
        low -= prev[1][0];
        mid -= prev[1][1];
        high -= prev[1][2];
        count -= 1;
      }
      rollingData[i] = [originalData[i][0], [ 1.0 * mid / count,
                                              1.0 * (mid - low) / count,
                                              1.0 * (high - mid) / count ]];
    }
  } else {
    // Calculate the rolling average for the first rollPeriod - 1 points where
    // there is not enough data to roll over the full number of days
    var num_init_points = Math.min(rollPeriod - 1, originalData.length - 2);
    if (!this.dataHasErrorBars_){
      for (var i = 0; i < num_init_points; i++) {
        var sum = 0;
        for (var j = 0; j < i + 1; j++)
          sum += originalData[j][1];
        rollingData[i] = [originalData[i][0], sum / (i + 1)];
      }
      // Calculate the rolling average for the remaining points
      for (var i = Math.min(rollPeriod - 1, originalData.length - 2);
          i < originalData.length;
          i++) {
        var sum = 0;
        for (var j = i - rollPeriod + 1; j < i + 1; j++)
          sum += originalData[j][1];
        rollingData[i] = [originalData[i][0], sum / rollPeriod];
      }
    } else {
      for (var i = 0; i < num_init_points; i++) {
        var sum = 0;
        var variance = 0;
        for (var j = 0; j < i + 1; j++) {
          sum += originalData[j][1][0];
          variance += Math.pow(originalData[j][1][1], 2);
        }
        var stddev = Math.sqrt(variance)/(i+1);
        rollingData[i] = [originalData[i][0],
                          [sum/(i+1), sigma * stddev, sigma * stddev]];
      }
      // Calculate the rolling average for the remaining points
      for (var i = Math.min(rollPeriod - 1, originalData.length - 2);
          i < originalData.length;
          i++) {
        var sum = 0;
        var variance = 0;
        for (var j = i - rollPeriod + 1; j < i + 1; j++) {
          sum += originalData[j][1][0];
          variance += Math.pow(originalData[j][1][1], 2);
        }
        var stddev = Math.sqrt(variance) / rollPeriod;
        rollingData[i] = [originalData[i][0],
                          [sum / rollPeriod, sigma * stddev, sigma * stddev]];
      }
    }
  }

  return rollingData;
};

/**
 * Parses a date, returning the number of milliseconds since epoch. This can be
 * passed in as an xValueParser in the DateGraph constructor.
 * @param {String} A date in YYYYMMDD format.
 * @return {Number} Milliseconds since epoch.
 * @public
 */
DateGraph.prototype.dateParser = function(dateStr) {
  var dateStrSlashed;
  if (dateStr.length == 10 && dateStr.search("-") != -1) {  // e.g. '2009-07-12'
    dateStrSlashed = dateStr.replace("-", "/", "g");
    while (dateStrSlashed.search("-") != -1) {
      dateStrSlashed = dateStrSlashed.replace("-", "/");
    }
    return Date.parse(dateStrSlashed);
  } else if (dateStr.length == 8) {  // e.g. '20090712'
    dateStrSlashed = dateStr.substr(0,4) + "/" + dateStr.substr(4,2)
                       + "/" + dateStr.substr(6,2);
    return Date.parse(dateStrSlashed);
  } else {
    // Any format that Date.parse will accept, e.g. "2009/07/12" or
    // "2009/07/12 12:34:56"
    return Date.parse(dateStr);
  }
};

/**
 * Parses a string in a special csv format.  We expect a csv file where each
 * line is a date point, and the first field in each line is the date string.
 * We also expect that all remaining fields represent series.
 * if this.errorBars_ is set, then interpret the fields as:
 * date, series1, stddev1, series2, stddev2, ...
 * @param {Array.<Object>} data See above.
 * @private
 */
DateGraph.prototype.parseCSV_ = function(data) {
  var ret = [];
  var lines = data.split("\n");
  var start = this.labelsFromCSV_ ? 1 : 0;
  if (this.labelsFromCSV_) {
    var labels = lines[0].split(",");
    labels.shift();  // a "date" parameter is assumed.
    this.labels_ = labels;
    // regenerate automatic colors.
    this.setColors_(this.attrs_);
    this.renderOptions_.colorScheme = this.colors_;
    MochiKit.Base.update(this.plotter_.options, this.renderOptions_);
    MochiKit.Base.update(this.layoutOptions_, this.attrs_);
  }

  for (var i = start; i < lines.length; i++) {
    var line = lines[i];
    if (line.length == 0) continue;  // skip blank lines
    var inFields = line.split(',');
    if (inFields.length < 2)
      continue;

    var fields = [];
    fields[0] = this.xValueParser_(inFields[0]);

    // If fractions are expected, parse the numbers as "A/B"
    if (this.fractions_) {
      for (var j = 1; j < inFields.length; j++) {
        // TODO(danvk): figure out an appropriate way to flag parse errors.
        var vals = inFields[j].split("/");
        fields[j] = [parseFloat(vals[0]), parseFloat(vals[1])];
      }
    } else if (this.dataHasErrorBars_) {
      // If there are error bars, values are (value, stddev) pairs
      for (var j = 1; j < inFields.length; j += 2) {
       fields[(j + 1) / 2] = [parseFloat(inFields[j]),
                             parseFloat(inFields[j + 1])];
      }
    } else if (this.customBars_) {
      // Bars are a low;center;high tuple
      for (var j = 1; j < inFields.length; j++) {
        var vals = inFields[j].split(";");
        fields[j] = [ parseFloat(vals[0]),
                      parseFloat(vals[1]),
                      parseFloat(vals[2]) ];
      }
    } else {
      // Values are just numbers
      for (var j = 1; j < inFields.length; j++)
        fields[j] = parseFloat(inFields[j]);
    }
    ret.push(fields);
  }
  return ret;
};

/**
 * Parses a DataTable object from gviz.
 * The data is expected to have a first column that is either a date or a
 * number. All subsequent columns must be numbers. If there is a clear mismatch
 * between this.xValueParser_ and the type of the first column, it will be
 * fixed. Returned value is in the same format as return value of parseCSV_.
 * @param {Array.<Object>} data See above.
 * @private
 */
DateGraph.prototype.parseDataTable_ = function(data) {
  var cols = data.getNumberOfColumns();
  var rows = data.getNumberOfRows();

  // Read column labels
  var labels = [];
  for (var i = 0; i < cols; i++) {
    labels.push(data.getColumnLabel(i));
  }
  labels.shift();  // the x-axis parameter is assumed and unnamed.
  this.labels_ = labels;
  // regenerate automatic colors.
  this.setColors_(this.attrs_);
  this.renderOptions_.colorScheme = this.colors_;
  MochiKit.Base.update(this.plotter_.options, this.renderOptions_);
  MochiKit.Base.update(this.layoutOptions_, this.attrs_);

  var indepType = data.getColumnType(0);
  if (indepType != 'date' && indepType != 'number') {
    // TODO(danvk): standardize error reporting.
    alert("only 'date' and 'number' types are supported for column 1" +
          "of DataTable input (Got '" + indepType + "')");
    return null;
  }

  var ret = [];
  for (var i = 0; i < rows; i++) {
    var row = [];
    if (indepType == 'date') {
      row.push(data.getValue(i, 0).getTime());
    } else {
      row.push(data.getValue(i, 0));
    }
    for (var j = 1; j < cols; j++) {
      row.push(data.getValue(i, j));
    }
    ret.push(row);
  }
  return ret;
}

/**
 * Get the CSV data. If it's in a function, call that function. If it's in a
 * file, do an XMLHttpRequest to get it.
 * @private
 */
DateGraph.prototype.start_ = function() {
  if (typeof this.file_ == 'function') {
    // Stubbed out to allow this to run off a filesystem
    this.loadedEvent_(this.file_());
  } else if (typeof this.file_ == 'object' &&
             typeof this.file_.getColumnRange == 'function') {
    // must be a DataTable from gviz.
    this.rawData_ = this.parseDataTable_(this.file_);
    this.drawGraph_(this.rawData_);
  } else {
    var req = new XMLHttpRequest();
    var caller = this;
    req.onreadystatechange = function () {
      if (req.readyState == 4) {
        caller.loadedEvent_(req.responseText);
      }
    };

    req.open("GET", this.file_, true);
    req.send(null);
  }
};

/**
 * Changes various properties of the graph. These can include:
 * <ul>
 * <li>file: changes the source data for the graph</li>
 * <li>errorBars: changes whether the data contains stddev</li>
 * </ul>
 * @param {Object} attrs The new properties and values
 */
DateGraph.prototype.updateOptions = function(attrs) {
  this.errorBars_ = attrs.errorBars || false;
 
  var old_stacked = this.stackedGraph_;

  this.stackedGraph_ = attrs.stackedGraph || false;
  this.shouldFill_ = (this.stackedGraph_ || false);

  if (attrs.customBars) {
    this.customBars_ = attrs.customBars;
  }
  if (attrs.strokeWidth) {
    this.strokeWidth_ = attrs.strokeWidth;
  }
  if (attrs.rollPeriod) {
    this.rollPeriod_ = attrs.rollPeriod;
  }
  if (attrs.dateWindow) {
    this.dateWindow_ = attrs.dateWindow;
  }
  if (attrs.valueRange) {
    this.valueRange_ = attrs.valueRange;
  }
  MochiKit.Base.update(this.attrs_, attrs);
  if (typeof(attrs.labels) != 'undefined') {
    this.labels_ = attrs.labels;
    this.labelsFromCSV_ = (attrs.labels == null);
  }
  this.layout_.updateOptions({ 'errorBars': this.errorBars_, 'shouldFill': this.shouldFill_ });
  // Reverse colors if we used to stack but dont anymore
  if (old_stacked && !this.stackedGraph_) {
    this.renderOptions_.colorScheme.reverse();
    this.colorsChanged_ = false;
  }
  if (attrs['file'] && attrs['file'] != this.file_) {
    this.file_ = attrs['file'];
    this.start_();
  } else {
    this.drawGraph_(this.rawData_);
  }
};

/**
 * Adjusts the number of days in the rolling average. Updates the graph to
 * reflect the new averaging period.
 * @param {Number} length Number of days over which to average the data.
 */
DateGraph.prototype.adjustRoll = function(length) {
  this.rollPeriod_ = length;
  this.drawGraph_(this.rawData_);
};


/**
 * A wrapper around DateGraph that implements the gviz API.
 * @param {Object} container The DOM object the visualization should live in.
 */
DateGraph.GVizChart = function(container) {
  this.container = container;
}

DateGraph.GVizChart.prototype.draw = function(data, options) {
  this.container.innerHTML = '';
  this.date_graph = new DateGraph(this.container, data, null, options || {});
}
