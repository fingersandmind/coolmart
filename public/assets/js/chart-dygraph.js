/*----chart dygraph1---*/
 new DateGraph(document.getElementById('dygraph-chart1'),
	data, null, {
		colors:["#17B794","#172f71","#17a2b8"] 
	},		  
);

/*----chart dygraph2---*/				  
new DateGraph(
	document.getElementById("dygraph-chart2"),
	
	NoisyData, null, {
	  rollPeriod: 5,
	  errorBars: true,
	  labelsDivWidth: 160,
	  labelsDivStyles: {
		'background-color': 'transparent',
		'top': '10px',
		'color':'#c0dfd8'
	  },
	  colors:["#17B794","#172f71","#17a2b8"],
	  padding: {
		left: 40,
		top: 0,
		right: 10,
		bottom: 10
	  }
	}
);

/*----chart dygraph3---*/
new DateGraph(
	document.getElementById("dygraph-chart3"),
	NoisyData, null, {
	  rollPeriod: 15,
	  errorBars: true,
	  gridLineColor: MochiKit.Color.Color.greenColor(),
	  highlightCircleSize: 15,
	  colors:["#17B794", "#172f71","#17a2b8"],
	  strokeWidth: 5,
	  padding: {
		left: 40,
		top: 0,
		right: 10,
		bottom: 10
	  }
	}
  );