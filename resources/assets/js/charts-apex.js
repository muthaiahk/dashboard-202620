/**
 * Charts Apex
 */

'use strict';

(function () {
  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    // labelColor = config.colors_dark.textMuted;
    labelColor = config.colors_dark.isDarkStyle;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors.isDarkStyle;
    // labelColor = config.colors.textMuted;
    labelColor = config.colors_dark.isDarkStyle;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }

  // Color constant
  const chartColors = {
    column: {
      series1: '#826af9',
      series2: '#d2b0ff',
      bg: '#f8d3ff'
      
    },
    donut: {
      series1: '#f74c20',
      series2: '#1ab69d',
      series3: '#ffaa17',
      series4: '#0070d9',
      series5: '#1397c7',
      series6: '#027cd6',
      series7: '#f74c20',
      series8: '#39484f',
      series9: '#5e8c36',
    },
    area: {
      
      series1: '#39484f',
      series2: '#39484f',
      series3: '#6f7e85'
      
    }
  };

  // Heat chart data generator
  function generateDataHeat(count, yrange) {
    let i = 0;
    let series = [];
    while (i < count) {
      let x = 'w' + (i + 1).toString();
      let y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

      series.push({
        x: x,
        y: y
      });
      i++;
    }
    return series;
  }

  // Line Area Chart
  // --------------------------------------------------------------------
  const currentYear = new Date().getFullYear();

  const areaChartEl = document.querySelector('#lineAreaChart'),
    areaChartConfig = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'area',
        toolbar: {
          show: false
        }
      },
      title: {
        
        text: "Weekly Time Analysis",
        align: 'center'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        curve: 'smooth',
        style: {
          colors: labelColor,
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'right',
        labels: {
          colors: legendColor,
          useSeriesColors: true
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [
        {
          name: 'Project 1',
          data: [4,2,4,0,0,1],
          color:'#73db80',
        },
        {
          name: 'Project 2',
          data: [0,6,2,0,2,7],
           color: '#f47507',
        
        },
        {
          name: 'Project 3',
          data: [1,0,2,4,2,0],
           color: '#1397c7'
        
        },
        {
          name: 'Project 4',
          data: [4,0,0,4,4,0],
           color: '#d22513'
        
        },
        {
          name: 'Project 5',
          data: [0,0,0,0,0,0],
           color: '#FFA07A'
        
        },
        {
          name: 'Project 6',
          data: [0,0,0,0,0,0],
           color: '#93739d'
        
        }
      ],
      xaxis: {
        categories: [
          "Mon", "Tue", "Wed", "Thu", "Fri","Sat"
        ],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          }
        }
      },
      exporting: {
        enabled: true,
        buttons: {
            contextButton: {
                menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF']
            }
        }
    },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          },
          formatter: function (value) {
            
             var a = value.toLocaleString('en-IN', {
                  maximumFractionDigits: 2,
                 
              });
            return a;
         
          }
        },
      },
      fill: false,
      tooltip: {
        shared: false,
       
      }
    };
  if (typeof areaChartEl !== undefined && areaChartEl !== null) {
    const areaChart = new ApexCharts(areaChartEl, areaChartConfig);
    areaChart.render();
  }
  
  // Staff Area Chart
  // --------------------------------------------------------------------
  {
  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    // labelColor = config.colors_dark.textMuted;
    labelColor = config.colors_dark.isDarkStyle;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors.isDarkStyle;
    // labelColor = config.colors.textMuted;
    labelColor = config.colors_dark.isDarkStyle;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }
}

  // Color constant
  const chartColors_staff = {
    column: {
      series1: '#826af9',
      series2: '#d2b0ff',
      bg: '#f8d3ff'
      
    },
    donut: {
      series1: '#fdd835',
      series2: '#32baff',
      series3: '#ffa1a1',
      series4: '#7367f0',
      series5: '#29dac7'
    },
    area: {
      series1: '#ff4d49',
      series2: '#ff4d49',
      series3: '#f2d8d8'
      
    }
  };
  
  const areaChartE2 = document.querySelector('#staffAreaChart'),
    areaChartConfig_1 = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'area',
        toolbar: {
          show: false
        }
      },
      title: {
        
        text: "August Month Goal Calculation",
        align: 'center'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        curve: 'smooth',
        style: {
          colors: labelColor,
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'right',
        labels: {
          colors: labelColor,
          fontSize:'14px',
          fontWeight:'bold',
          useSeriesColors: false
        },
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      colors: [chartColors_staff.area.series3, chartColors_staff.area.series2, chartColors_staff.area.series1],
      series: [
        {
          name: 'Target Amount',
          data: [50000,680000,1500000,2000000],
          color:'#73db80',
        },
        {
          name: 'Achieved Amount',
           data: [28000,980000,1300000,2050000],
           color: '#1397c7',
        
        },
      ],
      xaxis: {
        categories: [
          "Week-1", "Week-2", "Week-3", "Week-4"
        ],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          }
        }
      },
      exporting: {
        enabled: true,
        buttons: {
            contextButton: {
                menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF']
            }
        }
    },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          },
          formatter: function (value) {
            
             var a = value.toLocaleString('en-IN', {
                  maximumFractionDigits: 2,
                  style: 'currency',
                  currency: 'INR'
              });
            return a;
            // return value + "$";
          }
        },
      },
      fill: false,
      tooltip: {
        shared: false,
       
      }
    };
  if (typeof areaChartE2 !== undefined && areaChartE2 !== null) {
    const areaChart = new ApexCharts(areaChartE2, areaChartConfig_1);
    areaChart.render();
  }
  

  // Scatter Chart
  // --------------------------------------------------------------------
  const scatterChartEl = document.querySelector('#scatterChart'),
    scatterChartConfig = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'scatter',
        zoom: {
          enabled: true,
          type: 'xy'
        },
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'start',
        labels: {
          colors: legendColor,
          useSeriesColors: false
        }
      },
      colors: [config.colors.warning, config.colors.primary, config.colors.success],
      series: [
        {
          name: 'Angular',
          data: [
            [5.4, 170],
            [5.4, 100],
            [5.7, 110],
            [5.9, 150],
            [6.0, 200],
            [6.3, 170],
            [5.7, 140],
            [5.9, 130],
            [7.0, 150],
            [8.0, 120],
            [9.0, 170],
            [10.0, 190],
            [11.0, 220],
            [12.0, 170],
            [13.0, 230]
          ]
        },
        {
          name: 'Vue',
          data: [
            [14.0, 220],
            [15.0, 280],
            [16.0, 230],
            [18.0, 320],
            [17.5, 280],
            [19.0, 250],
            [20.0, 350],
            [20.5, 320],
            [20.0, 320],
            [19.0, 280],
            [17.0, 280],
            [22.0, 300],
            [18.0, 120]
          ]
        },
        {
          name: 'React',
          data: [
            [14.0, 290],
            [13.0, 190],
            [20.0, 220],
            [21.0, 350],
            [21.5, 290],
            [22.0, 220],
            [23.0, 140],
            [19.0, 400],
            [20.0, 200],
            [22.0, 90],
            [20.0, 120]
          ]
        }
      ],
      xaxis: {
        tickAmount: 10,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          formatter: function (val) {
            return parseFloat(val).toFixed(1);
          },
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      }
    };
  if (typeof scatterChartEl !== undefined && scatterChartEl !== null) {
    const scatterChart = new ApexCharts(scatterChartEl, scatterChartConfig);
    scatterChart.render();
  }

  // Line Chart
  // --------------------------------------------------------------------
  const lineChartEl = document.querySelector('#lineChart'),
    lineChartConfig = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'line',
        parentHeightOffset: 0,
        zoom: {
          enabled: false
        },
        toolbar: {
          show: false
        }
      },
      series: [
        {
          data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100, 150, 100, 50]
        }
      ],
      markers: {
        strokeWidth: 7,
        strokeOpacity: 1,
        strokeColors: [cardColor],
        colors: [config.colors.warning]
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      colors: [config.colors.warning],
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        },
        padding: {
          top: -20
        }
      },
      tooltip: {
        custom: function ({ series, seriesIndex, dataPointIndex, w }) {
          return '<div class="px-3 py-2">' + '<span>' + series[seriesIndex][dataPointIndex] + '%</span>' + '</div>';
        }
      },
      xaxis: {
        categories: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12',
          '20/12',
          '21/12'
        ],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      }
    };
  if (typeof lineChartEl !== undefined && lineChartEl !== null) {
    const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
    lineChart.render();
  }

  // Horizontal Bar Chart
  // --------------------------------------------------------------------
  const horizontalBarChartEl = document.querySelector('#horizontalBarChart'),
    horizontalBarChartConfig = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: '30%',
          startingShape: 'rounded',
          borderRadius: 8
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: false
          }
        },
        padding: {
          top: -20,
          bottom: -12
        }
      },
      colors: config.colors.info,
      dataLabels: {
        enabled: false
      },
      series: [
        {
          data: [700, 350, 480, 600, 210, 550, 150]
        }
      ],
      xaxis: {
        categories: ['MON, 11', 'THU, 14', 'FRI, 15', 'MON, 18', 'WED, 20', 'FRI, 21', 'MON, 23'],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      }
    };
  if (typeof horizontalBarChartEl !== undefined && horizontalBarChartEl !== null) {
    const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
    horizontalBarChart.render();
  }

  // Candlestick Chart
  // --------------------------------------------------------------------
  const candlestickEl = document.querySelector('#candleStickChart'),
    candlestickColors = {
      series1: '#28c76f',
      series2: '#ea5455'
    },
    candlestickChartConfig = {
      chart: {
        height: 410,
        fontFamily: 'Inter',
        type: 'candlestick',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      series: [
        {
          data: [
            {
              x: new Date(1538778600000),
              y: [150, 170, 50, 100]
            },
            {
              x: new Date(1538780400000),
              y: [200, 400, 170, 330]
            },
            {
              x: new Date(1538782200000),
              y: [330, 340, 250, 280]
            },
            {
              x: new Date(1538784000000),
              y: [300, 330, 200, 320]
            },
            {
              x: new Date(1538785800000),
              y: [320, 450, 280, 350]
            },
            {
              x: new Date(1538787600000),
              y: [300, 350, 80, 250]
            },
            {
              x: new Date(1538789400000),
              y: [200, 330, 170, 300]
            },
            {
              x: new Date(1538791200000),
              y: [200, 220, 70, 130]
            },
            {
              x: new Date(1538793000000),
              y: [220, 270, 180, 250]
            },
            {
              x: new Date(1538794800000),
              y: [200, 250, 80, 100]
            },
            {
              x: new Date(1538796600000),
              y: [150, 170, 50, 120]
            },
            {
              x: new Date(1538798400000),
              y: [110, 450, 10, 420]
            },
            {
              x: new Date(1538800200000),
              y: [400, 480, 300, 320]
            },
            {
              x: new Date(1538802000000),
              y: [380, 480, 350, 450]
            }
          ]
        }
      ],
      xaxis: {
        type: 'datetime',
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      yaxis: {
        tooltip: {
          enabled: true
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        },
        padding: {
          top: -20
        }
      },
      plotOptions: {
        candlestick: {
          colors: {
            upward: candlestickColors.series1,
            downward: candlestickColors.series2
          }
        },
        bar: {
          columnWidth: '40%'
        }
      }
    };
  if (typeof candlestickEl !== undefined && candlestickEl !== null) {
    const candlestickChart = new ApexCharts(candlestickEl, candlestickChartConfig);
    candlestickChart.render();
  }

  // Heat map chart
  // --------------------------------------------------------------------
  const heatMapEl = document.querySelector('#heatMapChart'),
    heatMapChartConfig = {
      chart: {
        height: 350,
        fontFamily: 'Inter',
        type: 'heatmap',
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        heatmap: {
          enableShades: false,

          colorScale: {
            ranges: [
              {
                from: 0,
                to: 10,
                name: '0-10',
                color: '#b9b3f8'
              },
              {
                from: 11,
                to: 20,
                name: '10-20',
                color: '#aba4f6'
              },
              {
                from: 21,
                to: 30,
                name: '20-30',
                color: '#9d95f5'
              },
              {
                from: 31,
                to: 40,
                name: '30-40',
                color: '#8f85f3'
              },
              {
                from: 41,
                to: 50,
                name: '40-50',
                color: '#8176f2'
              },
              {
                from: 51,
                to: 60,
                name: '50-60',
                color: '#7367f0'
              }
            ]
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      grid: {
        show: false
      },
      legend: {
        show: true,
        position: 'bottom',
        labels: {
          colors: legendColor,
          useSeriesColors: false
        },
        markers: {
          offsetY: 0,
          offsetX: -3
        },
        itemMargin: {
          vertical: 3,
          horizontal: 10
        }
      },
      stroke: {
        curve: 'smooth',
        width: 2,
        lineCap: 'round',
        colors: [cardColor]
      },
      series: [
        {
          name: 'SUN',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'MON',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'TUE',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'WED',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'THU',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'FRI',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        },
        {
          name: 'SAT',
          data: generateDataHeat(24, {
            min: 0,
            max: 60
          })
        }
      ],
      xaxis: {
        labels: {
          show: false,
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      }
    };
  if (typeof heatMapEl !== undefined && heatMapEl !== null) {
    const heatMapChart = new ApexCharts(heatMapEl, heatMapChartConfig);
    heatMapChart.render();
  }

  // Radial Bar Chart
  // --------------------------------------------------------------------
  const radialBarChartEl = document.querySelector('#radialBarChart'),
    radialBarChartConfig = {
      chart: {
        height: 380,
        fontFamily: 'Inter',
        type: 'radialBar'
      },
      colors: [chartColors.donut.series1, chartColors.donut.series2, chartColors.donut.series4],
      plotOptions: {
        radialBar: {
          size: 185,
          hollow: {
            size: '40%'
          },
          track: {
            margin: 10,
            background: config.colors_label.secondary
          },
          dataLabels: {
            name: {
              fontSize: '2rem'
            },
            value: {
              fontSize: '1.2rem',
              color: legendColor
            },
            total: {
              show: true,
              fontWeight: 400,
              fontSize: '1.125rem',
              color: headingColor,
              label: 'Comments',
              formatter: function (w) {
                return '80%';
              }
            }
          }
        }
      },
      grid: {
        borderColor: borderColor,
        padding: {
          top: -29,
          bottom: -31
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        labels: {
          colors: legendColor,
          useSeriesColors: false
        }
      },
      stroke: {
        lineCap: 'round'
      },
      series: [80, 50, 35],
      labels: ['Comments', 'Replies', 'Shares']
    };
  if (typeof radialBarChartEl !== undefined && radialBarChartEl !== null) {
    const radialChart = new ApexCharts(radialBarChartEl, radialBarChartConfig);
    radialChart.render();
  }

  // Radar Chart
  // --------------------------------------------------------------------
  const radarChartEl = document.querySelector('#slotgraphChart'),
    radarChartConfig = {
      chart: {
        height: 500,
        fontFamily: 'Inter',
        type: 'radar',
        toolbar: {
          show: false
        },
        dropShadow: {
          enabled: false,
          blur: 8,
          left: 1,
          top: 1,
          opacity: 0.2
        }
      },
      title: {
        text: "Slot Analysis for June Month",
        align: 'center'
      },
      legend: {
        show: true,
        position: 'bottom',
        labels: {
          colors: legendColor,
          useSeriesColors: false
        }
      },
      plotOptions: {
        radar: {
          polygons: {
            strokeColors: borderColor,
            connectorColors: borderColor
          }
        }
      },
      // yaxis: {
      //   show: false
      // },
      series: [
        {
          name: 'Morning Slot',
          data: [41000, 64000, 81000, 60000, 42000, 42000, 33000, 23000,56000,78000],
        label: 'Batch 1',
              borderColor: config.colors.primary,
              tension: 0.5,
              pointStyle: 'circle',
              backgroundColor: config.colors.primary,
              fill: true,
              pointRadius: 1,
              pointHoverRadius: 5,
              pointHoverBorderWidth: 5,
              pointBorderColor: 'transparent',
              pointHoverBorderColor: cardColor,
              pointHoverBackgroundColor: config.colors.primary
        },
        {
          name: 'Evening Slot',
          data: [65000, 46000, 42000, 25000, 58000, 63000, 76000, 43000,56000,78000]
        }
      ],
      colors: [chartColors.donut.series4, chartColors.donut.series3],
      xaxis: {
        categories: ["Batch 1","Batch 2","Batch 3","Batch 4","Batch 5","Batch 6","Batch 7","Batch 8","Batch 9","Batch 10"],
        labels: {
          show: true,
          style: {
            colors: [labelColor, labelColor, labelColor, labelColor, labelColor, labelColor, labelColor, labelColor],
            fontSize: '12px',
            fontWeight:'bold'
          }
        }
      },
      fill: {
        opacity: [1, 0.8]
      },
      stroke: {
        show: true,
        width: 0
      },
      markers: {
        size: 0
      },
      grid: {
        show: false,
        padding: {
          top: 0,
          bottom: -20
        }
      },
      tooltip: {
        y: {
          formatter: function(data) {
            return data
          }
        }
      },
      
    };
  if (typeof radarChartEl !== undefined && radarChartEl !== null) {
    const radarChart = new ApexCharts(radarChartEl, radarChartConfig);
    radarChart.render();
  }

  // Donut Chart
  // --------------------------------------------------------------------
  const donutChartEl = document.querySelector('#projectChart'),
    donutChartConfig = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'donut'
      },
      title: {
        text: "Project Progress For Aug Month",
        align: 'center'
      },
      labels: ['Total No of Projects','Project Completed','Project On Progress','Not yet Stated', 'Delayed Projects'],
      series: [50,25, 10,5,5],
      colors: [
        
        chartColors.donut.series1,
        chartColors.donut.series3,
        chartColors.donut.series4,
        chartColors.donut.series5,
        chartColors.donut.series2,
        chartColors.donut.series6,
        chartColors.donut.series7,
        chartColors.donut.series8,
        chartColors.donut.series9,
      ],
      stroke: {
        show: true,
        curve: 'straight'
      },
      dataLabels: {
        enabled: true,
        formatter: function (val, opt) {
          return parseInt(val, 10) + '%';
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        markers: { offsetX: -3 },
        fontSize:'14px',  
        fontWeight:'bold',
        itemMargin: {
          vertical: 3,
          horizontal: 10
        },
        labels: {      
          useSeriesColors: false
        }
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              name: {
                fontSize: '2rem'
              },
              value: {
                fontSize: '1.5rem',
                fontWeight:'bold',
             
                formatter: function (val) {
                  return parseInt(val, 10) ;
                }
              },
              total: {
                show: true,
                fontSize: '14px',
                fontWeight:'bold',
                color: headingColor,
                label: 'Projects',
                formatter: function (w) {
                  return;
                }
              }
            }
          }
        }
      },
      responsive: [
        {
          breakpoint: 992,
          options: {
            chart: {
              height: 380
            },
            legend: {
              position: 'bottom',
              labels: {
                colors: legendColor,
                useSeriesColors: false
              }
            }
          }
        },
        {
          breakpoint: 576,
          options: {
            chart: {
              height: 320
            },
            plotOptions: {
              pie: {
                donut: {
                  labels: {
                    show: true,
                    name: {
                      fontSize: '1.5rem'
                    },
                    value: {
                      fontSize: '1rem'
                    },
                    total: {
                      fontSize: '1.5rem'
                    }
                  }
                }
              }
            },
            legend: {
              position: 'bottom',
              labels: {
                colors: legendColor,
                useSeriesColors: false
              }
            }
          }
        },
        {
          breakpoint: 420,
          options: {
            chart: {
              height: 280
            },
            legend: {
              show: false
            }
          }
        },
        {
          breakpoint: 360,
          options: {
            chart: {
              height: 250
            },
            legend: {
              show: false
            }
          }
        }
      ]
    };
  if (typeof donutChartEl !== undefined && donutChartEl !== null) {
    const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
    donutChart.render();
  }


    // Line Area Chart
  // --------------------------------------------------------------------

  const areaChartE7 = document.querySelector('#service_costing'),
    areaChartConfig_7 = {
      chart: {
        height: 400,
        fontFamily: 'Inter',
        type: 'area',
        toolbar: {
          show: false
        }
      },
      title: {
        
        text: "Monthly Revenue Calculation",
        align: 'center'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        curve: 'smooth',
        style: {
          colors: labelColor,
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'right',
        labels: {
          colors: legendColor,
          useSeriesColors: true
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [
        {
          name: 'Month Revenue Calculation',
          data: [700000,450000,500000,250000,300000,350000,400000,450000,500000,550000,600000,650000],
          color:'#73db80',
        }
      ],
      xaxis: {
        categories: [
          "Jan", "Feb", "Mar", "Apr", "May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"
        ],
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          }
        }
      },
      exporting: {
        enabled: true,
        buttons: {
            contextButton: {
                menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF']
            }
        }
    },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '12px',
            fontWeight:'bold'
          },
          formatter: function (value) {
            
             var a = value.toLocaleString('en-IN', {
                  maximumFractionDigits: 2,
                 
              });
            return a;
         
          }
        },
      },
      fill: false,
      tooltip: {
        shared: false,
       
      }
    };
  if (typeof areaChartE7 !== undefined && areaChartE7 !== null) {
    const areaChart = new ApexCharts(areaChartE7, areaChartConfig_7);
    areaChart.render();
  }

  const areaChartE8 = document.querySelector('#staffcosting'),
  areaChartConfig_8 = {
    chart: {
      height: 400,
      fontFamily: 'Inter',
      type: 'area',
      toolbar: {
        show: false
      }
    },
    title: {
      
      text: "August Month Staff Achievement",
      align: 'center'
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      curve: 'smooth',
      style: {
        colors: labelColor,
      }
    },
    legend: {
      show: true,
      position: 'bottom',
      horizontalAlign: 'right',
      labels: {
        colors: labelColor,
        fontSize:'14px',
        fontWeight:'bold',
        useSeriesColors: false
      },
    },
    grid: {
      borderColor: borderColor,
      xaxis: {
        lines: {
          show: true
        }
      }
    },
    colors: [chartColors_staff.area.series3, chartColors_staff.area.series2, chartColors_staff.area.series1],
    series: [
      {
        name: 'Target Amount',
        data: [8000000,7000000, 6000000, 5000000, 4000000,5000000, 4000000],
        color:'#73db80',
      },
      {
        name: 'Achieved Amount',
         data: [6000000,6500000, 5500000, 5000000, 4500000,5000000, 4000000],
         color: '#1397c7',
      
      },
    ],
    xaxis: {
      categories: [
        "Nila", "Yasmin", "Anu", "Priya", "sabana","Madhu","Amirtha"
      ],
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      },
      labels: {
        style: {
          colors: labelColor,
          fontSize: '12px',
          fontWeight:'bold'
        }
      }
    },
    exporting: {
      enabled: true,
      buttons: {
          contextButton: {
              menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF']
          }
      }
  },
    yaxis: {
      labels: {
        style: {
          colors: labelColor,
          fontSize: '12px',
          fontWeight:'bold'
        },
        formatter: function (value) {
          
           var a = value.toLocaleString('en-IN', {
                maximumFractionDigits: 2,
                style: 'currency',
                currency: 'INR'
            });
          return a;
          // return value + "$";
        }
      },
    },
    fill: false,
    tooltip: {
      shared: false,
     
    }
  };
if (typeof areaChartE8 !== undefined && areaChartE8 !== null) {
  const areaChart = new ApexCharts(areaChartE8, areaChartConfig_8);
  areaChart.render();
}
  
})();
