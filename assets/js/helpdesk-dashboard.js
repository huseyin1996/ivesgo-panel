(function () {
    "use strict";
    
    var options = {
        series: [{
          name: 'Total Tickets',
          type: 'area',
          data: [35, 23, 55, 47, 39, 58, 72, 50, 70, 66, 34, 45], // Adjusted for smoother waves
        }, {
          name: 'Resolved',
          type: 'line',
          data: [20, 40, 42, 52, 63, 48, 60, 40, 30, 68, 55, 74], // Adjusted for smoother waves
        }, {
          name: 'Pending',
          type: 'line',
          data: [45, 28, 15, 20, 23, 30, 50, 18, 47, 30, 20, 95], // Adjusted for smoother waves
        }],
        chart: {
          height: 323,
          type: 'line',
          dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 4,
            left: 0,
            blur: 4,
            color: ["var(--primary-color)", "rgb(0, 161, 255)", "rgb(243, 146, 1)"],
            opacity: 0.1,
          },
          toolbar: {
            show: false,
          },
          zoom: {
            enabled: false
          }
        },
        fill: {
            type:["gradient", "solid", "solid"],
            gradient: {
              shadeIntensity: 1,
              type: "vertical",
              opacityFrom: 0.4,
              opacityTo: 0.1,
              stops: [0, 90, 100],
              colorStops: [
                  [
                      {
                          offset: 0,
                          color: "var(--primary-color)",
                          opacity: 0.1
                      },
                      {
                          offset: 75,
                          color: "var(--primary-color)",
                          opacity: 0.02
                      },
                      {
                          offset: 100,
                          color: 'var(--primary-color)',
                          opacity: 0
                      }
                  ],
                  [
                      {
                          offset: 0,
                          color: "rgba(var(--secondary-rgb))",
                          opacity: 1
                      },
                      {
                          offset: 75,
                          color: "rgba(var(--secondary-rgb))",
                          opacity: 1
                      },
                      {
                          offset: 100,
                          color: 'rgba(var(--secondary-rgb))',
                          opacity: 1
                      }
                  ],
                  [
                    {
                        offset: 0,
                        color: "rgba(var(--dark-rgb))",
                        opacity: 1
                    },
                    {
                        offset: 75,
                        color: "rgba(var(--dark-rgb))",
                        opacity: 1
                    },
                    {
                        offset: 100,
                        color: 'rgba(var(--dark-rgb))',
                        opacity: 1
                    }
                ],
              ]
            }
          },
        grid: {
          borderColor: '#f1f1f1',
          strokeDashArray: 3
        },
        stroke: {
          curve: ['smooth', 'smooth', 'smooth'],
          width: [2.1, 2.1, 2],
          dashArray: [0,0,5]
        },
        legend: {
          show: true,
          position: 'top',
          horizontalAlign: 'center',
          fontSize: '14px',
          markers: {
            size: 5,
            offsetY: 2,
          },
        },
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb), 1)", "rgba(var(--dark-rgb), 0.5)"],
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      };
      var chart = new ApexCharts(document.querySelector("#support-analytics"), options);
      chart.render();


      var options = {
        chart: {
            height: 200,
            type: "donut",
        },
        dataLabels: {
          enabled: false,
        },
        series: [70, 56, 40],
        labels: ["Email", "Livachat", "Contact"],
        colors: ["var(--primary-color)", "rgba(var(--secondary-rgb),1)", "rgba(var(--light-rgb),1)"],
        plotOptions: {
          pie: {
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
                          fontFamily: "Google Sans, sans-serif",
                          offsetY: -5
                      },
                      value: {
                          show: true,
                          fontSize: '22px',
                          color: undefined,
                          offsetY: 10,
                          fontWeight: 600,
                          fontFamily:  "'Google Sans', sans-serif",
                          formatter: function (val) {
                              return val + "%"
                          }
                      },
                      total: {
                          show: true,
                          showAlways: true,
                          label: 'Total Tickets',
                          fontSize: '14px',
                          fontFamily:  "'Google Sans', sans-serif",
                          fontWeight: 500,
                          color: '#495057',
                      }
                  }
              }
          }
      },
        stroke: {
            lineCap: "round",
        },
      legend: {
          show: true,
          offsetX: -15,
          markers: {
            size:5,
          },
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
      }],
    };
    var chart1 = new ApexCharts(document.querySelector("#tickets-by-category"), options);
    chart1.render();

})()