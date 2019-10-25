( function ( $ ) {
	"use strict";
    var ctx = document.getElementById( "lineChart1" );
    ctx.height = 100;
	
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: [ "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018"],
            datasets: [
                {
                    label: "Profit",
                    borderColor: "rgb(29, 193, 157)",
                    borderWidth: "1",
                    backgroundColor: "rgb(32, 208, 170, 0.9)",
                    data: [0, 30, 60, 25, 60, 25, 50, 10, 50, 90, 120]
                            },
                {
                    label: "sales",
                    borderColor: "rgb(23, 47, 113)",
                    borderWidth: "1",
                    backgroundColor: "rgba(23, 47, 113, 0.9)",
                    pointHighlightStroke: "rgba(26, 179, 148, 1)",
                    data: [0, 60, 25, 100, 20, 75, 30, 55, 20, 60, 20],
                            }
                        ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false,
				
            },
			tooltips: {
				  
				},
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    } );
} )( jQuery );

