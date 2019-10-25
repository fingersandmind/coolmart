(function($) {
    "use strict";

// ______________Full screen
	$("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })



// ______________ PAGE LOADING
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
	})

	// ______________ BACK TO TOP BUTTON

	$(window).on("scroll", function(e) {
    	if ($(this).scrollTop() > 300) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });

    $("#back-to-top").on("click", function(e){
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".rating-stars").ratingStars(ratingOptions);
	$(".vscroll").mCustomScrollbar();
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: '#f6f6f6',
			  lineCap: 'round'
			});
		});
	  }
})(jQuery);

$(function(e) {
		  /** Constant div card */
	  const DIV_CARD = 'div.card';
	  /** Initialize tooltips */
	  $('[data-toggle="tooltip"]').tooltip();

	  /** Initialize popovers */
	  $('[data-toggle="popover"]').popover({
		html: true
	  });
			 /** Function for remove card */
	  $('[data-toggle="card-remove"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.remove();

		e.preventDefault();
		return false;
	  });

	  /** Function for collapse card */
	  $('[data-toggle="card-collapse"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-collapsed');

		e.preventDefault();
		return false;
	  });
	  $('[data-toggle="card-fullscreen"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');

		e.preventDefault();
		return false;
	  });
  });


