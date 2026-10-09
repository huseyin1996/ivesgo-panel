(function () {
    'use strict';

    const options2 = {
        series: [
          {
            name: "This year",
            data: [13, 23, 20, 25, 10, 13, 13, 15, 13, 23, 20, 25],
            type: "column",
          },
          {
            name: "Last Year",
            data: [20, 30, 25, 50, 25, 30, 20, 35, 20, 30, 25, 50],
            type: "line",
          },
        ],
        chart: {
          type: "line",
          height: 350,
          toolbar: {
            show: false,
          },
          zoom: {
            enabled: true,
          },
          stacked: true,
        },
        grid: {
          show: true,
          borderColor: "rgba(119, 119, 142, 0.1)",
          strokeDashArray: 4,
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb),1)"],
        stroke: {
          curve: 'smooth',
          width: ['3', '2.2'],
          dashArray: ['0', '0']
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "40%",
            borderRadius: "3",
          },
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          labels: {
            show: true,
            style: {
              colors: "#8c9097",
              fontSize: "11px",
              fontWeight: 600,
              cssClass: "apexcharts-xaxis-label",
              fontFamily: "Mulish, sans-serif",
            },
          },
        },
        legend: {
          show: true,
          position: "bottom",
          offsetX: 0,
          offsetY: 10,
          markers: {
            width: 10,
            height: 10,
            strokeWidth: 0,
            strokeColor: "#fff",
            fillColors: undefined,
            radius: 12,
            customHTML: undefined,
            onClick: undefined,
            offsetX: 0,
            offsetY: 0,
          },
        },
        yaxis: {
          labels: {
            show: true,
            style: {
              colors: "#8c9097",
              fontSize: "11px",
              fontWeight: 600,
              cssClass: "apexcharts-xaxis-label",
              fontFamily: "Mulish, sans-serif",
            },
          },
        },
      };
      const chart = new ApexCharts(document.querySelector("#traffic-overview"), options2);
      if(chart) chart.render();

      var options = {
        series: [1854, 1287, 684, 367],
        labels: ["Mobile", "Desktop", "Tablet", "Laptop"],
        chart: {
            height: 175,
            type: 'donut',
        },
        dataLabels: {
            enabled: false,
        },
    
        legend: {
            show: true,
            itemMargin: {
              horizontal: 2,
              vertical: 0
            },
            markers: {
              size:5,
            }
        },
        stroke: {
            show: true,
            curve: 'smooth',
            lineCap: 'round',
            colors: "#fff",
            width: 3,
            dashArray: 0,
        },
        plotOptions: {
            pie: {
                startAngle: -100,
                endAngle: 100,
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
                            fontFamily: "Google Sans, sans-serif",
                            offsetY: -30
                        },
                        value: {
                            show: true,
                            fontSize: '22px',
                            color: undefined,
                            offsetY: -15,
                            fontWeight: 600,
                            fontFamily:  "'Google Sans', sans-serif",
                            formatter: function (val) {
                                return val + "%"
                            }
                        },
                        total: {
                            show: true,
                            showAlways: true,
                            label: 'Total Posts',
                            fontSize: '14px',
                            fontFamily:  "'Google Sans', sans-serif",
                            fontWeight: 500,
                            color: '#495057',
                        }
                    }
                }
            }
        },
        grid: {
          padding: {
            bottom: -85
          }
        },
        responsive: [{
          breakpoint: 576,
          options: {
              legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                markers: {
                  size:4,
                },
                itemMargin: {
                  horizontal: 2,
                  vertical: 0
                }
              }
          }
        },
        {
          breakpoint: 1199,
          options: {
              legend: {
                show: true,
                position: 'right',
                horizontalAlign: 'center',
                fontSize: '13px',
                markers: {
                  size:4,
                },
                itemMargin: {
                  horizontal: 2,
                  vertical: 0
                }
              }
          }
        },
        {
          breakpoint: 1400,
          options: {
              legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                markers: {
                  size:4,
                },
                itemMargin: {
                  horizontal: 2,
                  vertical: 0
                }
              }
          }
        }
      ],
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)","rgba(var(--warning-rgb),1)", "rgba(16, 25, 47, 0.06)"],
    };
    var chart1 = new ApexCharts(document.querySelector("#device-analytics"), options);
    chart1.render();

})();

