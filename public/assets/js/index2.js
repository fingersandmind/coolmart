$(function(e){
  'use strict'	
  
	/*-----echartArea2-----*/
  var areaData2 = [
    {
      name: 'Sales',
      type: 'line',
      smooth: true,
      data: [0,5,15,19,22,30],
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
      name: 'Profit',
      type: 'line',
      smooth: true,
      data: [1, 10, 15, 10, 10, 25],
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

  var optionArea2 = {
    grid: {
      top: '6',
      right: '12',
      bottom: '17',
      left: '25',
    },
    xAxis: {
      data: [ '2013', '2014', '2015', '2016', '2017', '2018'],
      boundaryGap: false,
      axisLine: {
        lineStyle: { color: '#c0dfd8' }
      },
      axisLabel: {
        fontSize: 10,
        color: '#000',
		display:'false'
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
        lineStyle: { color: '#eaeaea' },
		display:false
      },
      axisLine: {
        lineStyle: { color: '#eaeaea' },
		display:false
      },
      axisLabel: {
        fontSize: 10,
        color: '#000'
      }
    },
    series: areaData2,
    color:[ '#172f71','#17B794']
  };
	
  var chartArea2 = document.getElementById('echartArea2');
  var areaChart2 = echarts.init(chartArea2);
  areaChart2.setOption(optionArea2);
  
  
   /*-----echartpie-----*/
   
  var pieData = [{
    name: 'Designation',
    type: 'pie',
    radius: '60%',
    center: ['50%', '50%'],
    data: [
      {value: 525, name: 'sales', color:'#000' },
      {value: 310, name: 'profit', color:'#c0dfd8'},
      {value: 134, name: 'growth', color:'#c0dfd8'}
    ],
	color:[ '#17B794','#172f71','#ecb403'],
	responsive: true,
    label: {
      normal: {
        fontFamily: 'Roboto, sans-serif',
        fontSize: 11,
		responsive: true
      }
    },
	 options: {
          maintainAspectRatio: false,
          responsive: true,
		  
	 },
    labelLine: {
      normal: {
        show: false,
		responsive: true
      }
    },
    markLine: {
      lineStyle: {
        normal: {
          width: 'auto',
		  responsive: true
        }
      }
    }
  }];

  var pieOption = {
    tooltip: {
      trigger: 'item',
      formatter: '{a} <br/>{b}: {c} ({d}%)',
      textStyle: {
        fontSize: 11,
        fontFamily: 'Roboto, sans-serif'
      }
    },
    series: pieData
  };

  var pie = document.getElementById('echartPie');
  var pieChart = echarts.init(pie);
  pieChart.setOption(pieOption);


  
  /*-----echartdonut-----*/
  
  var donutData = [{
    name: 'Designation',
    type: 'pie',
    radius: ['30%','55%'],
    center: ['50%', '50%'],
    data: [
      {value: 635, name: 'WebDesigners'},
      {value: 450, name: 'Developers'},
      {value: 234, name: 'Accountants'},
      {value: 324, name: 'System Engineers'}
    ],
	color:[ '#17B794','#172f71','#45aaf2','#ecb403'],
    label: {
      normal: {
        fontFamily: 'Roboto, sans-serif',
        fontSize: 11
      }
    },
    labelLine: {
      normal: {
        show: false
      }
    },
    markLine: {
      lineStyle: {
        normal: {
          width: 1
        }
      }
    }
  }];

  var donutOption = {
    tooltip: {
      trigger: 'item',
      formatter: '{a} <br/>{b}: {c} ({d}%)',
      textStyle: {
        fontSize: 11,
        fontFamily: 'Roboto, sans-serif'
      }
    },
    series: donutData
  };

  var donut = document.getElementById('echartDonut');
  var donutChart = echarts.init(donut);
  donutChart.setOption(donutOption);

  
});
