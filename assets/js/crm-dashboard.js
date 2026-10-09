(function () {
    "use strict";
    /* Total Customers */
    var options1 = {
        chart: {
            type: "bar",
            height: 75,
            width: 75,
            sparkline: {
              enabled: true
            },
            stacked: true,
            toolbar: {
              show: false
            },
        },
        series: [
        {
            data: [8, 11, 15, 17, 10]
            // data: [8, 11, 15, 17, 10, 16, 14]
        },
        ],
        plotOptions: {
        bar: {
            columnWidth: "60%",
            borderRadius: 1,
            distributed: true,
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last"
        }
        },
        colors: ["rgba(var(--primary-rgb),0.1)","rgba(var(--primary-rgb),0.1)","var(--primary-color)", "rgba(var(--primary-rgb),0.1)", "rgba(var(--primary-rgb),0.1)", "rgba(var(--primary-rgb),0.1)", "rgba(var(--primary-rgb),0.1)"],
        dataLabels: {enabled: false},
        legend: {
        show: false
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return ''
                    }
                }
            },
            marker: {
                show: true
            }
        }
    };
    var chart1 = new ApexCharts(document.querySelector("#crm-total-customers"), options1);
    chart1.render();
    /* Total Customers */
  
    /* Total Deals */
    var options2 = {
        series: [{
            data: [32, 63, 59, 45, 72]
            // data: [32, 63, 59, 45, 72, 31, 84]
        }],
        chart: {
            type: "bar",
            height: 75,
            width: 75,
            sparkline: {
              enabled: true
            },
            stacked: true,
            toolbar: {
              show: false
            },
        },
        plotOptions: {
        bar: {
            columnWidth: "60%",
            borderRadius: 1,
            distributed: true,
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last"
        }
        },
        colors: ["rgba(var(--success-rgb),0.1)","rgba(var(--success-rgb),0.1)","rgba(var(--success-rgb),1)", "rgba(var(--success-rgb),0.1)", "rgba(var(--success-rgb),0.1)", "rgba(var(--success-rgb),0.1)", "rgba(var(--success-rgb),0.1)"],
        dataLabels: {enabled: false},
        legend: {
        show: false
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return ''
                    }
                }
            },
            marker: {
                show: true
            }
        }
    };
    var chart2 = new ApexCharts(document.querySelector("#crm-total-deals"), options2);
    chart2.render();
    /* Total Deals */
  
    /* Total Revenue */
    var options3 = {
        series: [{
            data: [8, 11, 15, 17, 10]
            // data: [8, 11, 15, 17, 10, 16, 14]
        }],
        chart: {
            type: "bar",
            height: 75,
            width: 75,
            sparkline: {
              enabled: true
            },
            stacked: true,
            toolbar: {
              show: false
            },
        },
        plotOptions: {
        bar: {
            columnWidth: "60%",
            borderRadius: 1,
            distributed: true,
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last"
        }
        },
        colors: ["rgba(var(--secondary-rgb),0.1)","rgba(var(--secondary-rgb),1)","rgba(var(--secondary-rgb),0.1)", "rgba(var(--secondary-rgb),0.1)", "rgba(var(--secondary-rgb),0.1)", "rgba(var(--secondary-rgb),0.1)", "rgba(var(--secondary-rgb),0.1)"],
        dataLabels: {enabled: false},
        legend: {
        show: false
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return ''
                    }
                }
            },
            marker: {
                show: true
            }
        }
    };
    var chart3 = new ApexCharts(document.querySelector("#crm-total-revenue"), options3);
    chart3.render();
    /* Total Revenue */
  
    /* Total Conversion Ratio */
    var options4 = {
        series: [{
            data: [8, 11, 15, 17, 10]
            // data: [8, 11, 15, 17, 10, 16, 14]
        }],
        chart: {
            type: "bar",
            height: 75,
            width: 75,
            sparkline: {
              enabled: true
            },
            stacked: true,
            toolbar: {
              show: false
            },
        },
        plotOptions: {
        bar: {
            columnWidth: "60%",
            borderRadius: 1,
            distributed: true,
            borderRadiusApplication: "end",
            borderRadiusWhenStacked: "last"
        }
        },
        colors: ["rgba(var(--warning-rgb),0.1)","rgba(var(--warning-rgb),0.1)", "rgba(var(--warning-rgb),0.1)", "rgba(var(--warning-rgb),1)","rgba(var(--warning-rgb),0.1)", "rgba(var(--warning-rgb),0.1)", "rgba(var(--warning-rgb),0.1)"],
        dataLabels: {enabled: false},
        legend: {
        show: false
        },
        tooltip: {
            fixed: {
                enabled: false
            },
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function (seriesName) {
                        return ''
                    }
                }
            },
            marker: {
                show: true
            }
        }
    };
    var chart4 = new ApexCharts(document.querySelector("#crm-total-conversion"), options4);
    chart4.render();
    /* Total Conversion Ratio */
  
    //Revenue Chart//
    var options = {
        series: [
            {
              name: 'Actual',
              data: [
                {
                  x: 'Jan',
                  y: 120,
                  goals: [
                    {
                      name: 'Expected',
                      value: 140,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Feb',
                  y: 150,
                  goals: [
                    {
                      name: 'Expected',
                      value: 160,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Jan',
                  y: 170,
                  goals: [
                    {
                      name: 'Expected',
                      value: 180,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Mar',
                  y: 120,
                  goals: [
                    {
                      name: 'Expected',
                      value: 140,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Apr',
                  y: 150,
                  goals: [
                    {
                      name: 'Expected',
                      value: 160,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'May',
                  y: 170,
                  goals: [
                    {
                      name: 'Expected',
                      value: 180,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Jun',
                  y: 140,
                  goals: [
                    {
                      name: 'Expected',
                      value: 150,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Jul',
                  y: 100,
                  goals: [
                    {
                      name: 'Expected',
                      value: 110,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Aug',
                  y: 110,
                  goals: [
                    {
                      name: 'Expected',
                      value: 120,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Sep',
                  y: 150,
                  goals: [
                    {
                      name: 'Expected',
                      value: 160,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Oct',
                  y: 120,
                  goals: [
                    {
                      name: 'Expected',
                      value: 130,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Nov',
                  y: 90,
                  goals: [
                    {
                      name: 'Expected',
                      value: 100,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                },
                {
                  x: 'Dec',
                  y: 180,
                  goals: [
                    {
                      name: 'Expected',
                      value: 190,
                      strokeHeight: 3,
                      strokeLineCap: 'round',
                      strokeColor: 'var(--primary-color)'
                    }
                  ]
                }
              ]
            }
        ],
        chart: {
            height: 343,
            type: 'bar'
        },
        plotOptions: {
            bar: {
                columnWidth: "40%",
                borderRadius: 2,
                borderRadiusApplication: "end",
                borderRadiusWhenStacked: "last"
            }
        },
        colors: ['rgba(var(--primary-rgb),0.3)'],
        dataLabels: {
            enabled:false,
        },
        legend: {
            show: true,
            position: 'top',
            showForSingleSeries: true,
            customLegendItems: ['Actual', 'Expected'],
            markers: {
              fillColors: ['rgba(var(--primary-rgb),0.3)', 'var(--primary-color)']
            }
        },
    };
    var chart = new ApexCharts(document.querySelector("#crmRevenueChart"), options);
    chart.render();
    //Revenue Chart//
  
    //leads Sources//
    var options = {
      series: [18235, 12743, 8369, 16458],
      labels: ["Mobile", "Desktop", "Laptop", "Tablet"],
      chart: {
        height: 320,
        type: 'donut',
      },
      dataLabels: { 
        enabled: false,
      },
      legend: {
        show: false,
      },
      stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'round',
        colors: "#fff",
        width: 0,
        dashArray: 0,
      },
      stroke: {
        width: 2,
      },
      plotOptions: {
        pie: {
          startAngle: -90,
          endAngle: 90,
          offsetY: 10,
          expandOnClick: false,
          donut: {
            size: '80%',
            background: 'transparent',
            labels: {
              show: true,
              name: {
                show: true,
                fontSize: '20px',
                color: '#495057',
                fontFamily: "Montserrat, sans-serif",
                offsetY: -55
              },
              value: {
                show: true,
                fontSize: '22px',
                color: undefined,
                offsetY: -45,
                fontWeight: 600,
                fontFamily: "Montserrat, sans-serif",
                formatter: function (val) {
                  return val + "%"
                }
              },
              total: {
                show: true,
                showAlways: true,
                label: 'Total Visitors',
                fontSize: '14px',
                fontWeight: 400,
                color: '#495057',
              }
            }
          }
        }
      },
      grid: {
        enabled:false,
        show: false,
        padding: {
          bottom: -160
        }
      },
      colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)", "rgba(var(--success-rgb), 1)", "rgba(var(--warning-rgb),1)"],
    };
    var chart = new ApexCharts(document.querySelector("#leads-sources"), options);
    chart.render();
    //leads Sources//
  
  })();