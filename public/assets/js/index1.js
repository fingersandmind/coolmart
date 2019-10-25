$(function(e){
  'use strict'
  /*-----echart2-----*/
   
  var chartdata = [
    {
      name: 'sales',
      type: 'line',
	  smooth:true,
	  data: [12, 25, 22, 30, 14, 0],
    },
    {
      name: 'profit',
      type: 'line',
	   smooth:true,
      data: [0, 10, 25, 10, 30, 0],
	  lineStyle: {
        normal: { width: 1 }
      },
      itemStyle: {
        normal: {
          areaStyle: { type: 'default' }
        }
      }
    },
    {
      name: 'growth',
      type: 'line',
	   smooth:true,
      data: [0, 20, 10, 15, 8, 5, 0],
	  lineStyle: {
        normal: { width: 1 }
      },
      itemStyle: {
        normal: {
          areaStyle: { type: 'default' }
        }
      }
    }
  ];

  var chart = document.getElementById('echart1');
  var barChart = echarts.init(chart);

  var option = {
    grid: {
      top: '6',
      right: '0',
      bottom: '17',
      left: '25',
    },
    xAxis: {
      data: [  '2013', '2014', '2015', '2016', '2017', '2018'],
      axisLine: {
        lineStyle: {
          color: '#eaeaea'
        }
      },
      axisLabel: {
        fontSize: 10,
        color: '#000'
      }
    },
	tooltip: {
		show: true,
		showContent: true,
		alwaysShowContent: true,
		triggerOn: 'mousemove',
		trigger: 'axis',
		axisPointer:
		{
			label: {
				show: false,
			}
		}

	},
    yAxis: {
      splitLine: {
        lineStyle: {
          color: '#eaeaea'
        }
      },
      axisLine: {
        lineStyle: {
          color: '#eaeaea'
        }
      },
      axisLabel: {
        fontSize: 10,
        color: '#000'
      }
    },
    series: chartdata,
    color:[ '#ecb403','#15af8d','#172f71',]
  };

  barChart.setOption(option);

  });