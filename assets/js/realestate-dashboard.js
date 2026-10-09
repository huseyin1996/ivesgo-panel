(function () {
    "use strict";
  
     /* Rented Properies */
     var options = {
        series: [{
            data: [98, 110, 80, 145, 105, 112, 87, 148, 102]
        }],
        chart: {
            height: 105,
            type: 'area',
            foreColor: '#5d6162',
            zoom: {
                enabled: false
            },
            sparkline: {
                enabled: true
            }
        },
        tooltip: {
            enabled: true,
            theme: "dark",
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
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: undefined,
        },
        grid: {
            borderColor: 'transparent',
        },
        xaxis: {
            crosshairs: {
                show: false,
            }
        },
        colors: ["rgba(var(--secondary-rgb),1)"],
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.5,
                opacityTo: 0.2,
                stops: [0, 60],
                colorStops: [
                    [
                        {
                            offset: 0,
                            color: 'rgba(var(--secondary-rgb),0.2)',
                            opacity: 1
                        },
                        {
                            offset: 60,
                            color: 'rgba(var(--secondary-rgb),0.1)',
                            opacity: 0.1
                        },
                        {
                            offset: 100,
                            color: 'rgba(86, 204, 1, 0)',
                            opacity: 1
                        }
                    ],
                ]
            },
        },
        stroke: {
            width: [2],
        }
    };
    var chart3 = new ApexCharts(document.querySelector("#rented-propery-chart"), options);
    chart3.render();
    /* Rented Properies */

    /* Saled Properies */
    var options = {
        series: [{
            data: [98, 110, 80, 145, 105, 112, 87, 148, 102,55, 87]
        }],
        chart: {
            height: 105,
            type: 'bar',
            foreColor: '#5d6162',
            zoom: {
                enabled: false
            },
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "40%",
              borderRadius: "3",
            },
        },
        tooltip: {
            enabled: true,
            theme: "dark",
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
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: undefined,
        },
        grid: {
            borderColor: 'transparent',
        },
        xaxis: {
            crosshairs: {
                show: false,
            }
        },
        colors: ["rgba(var(--primary-rgb),0.95)"],
        stroke: {
            width: [2],
        }
    };
    var chart3 = new ApexCharts(document.querySelector("#saled-propery-chart"), options);
    chart3.render();
    /* Saled Properies */

    /*  Properties Statistics */
    var options1 = {
        series: [{
          name: 'Weekly',
          data: [31, 11, 22, 37, 13, 22, 37, 21, 44, 22, 34, 25],
          type: "column",
        }, {
          name: 'Monthly',
          data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 23],
          type: "area",
        }, {
          name: 'Daily',
          data: [30, 8, 20, 36, 15, 22, 37, 19, 44, 24, 32, 23],
          type: "line",
        },],
        chart: {
          height: 280,
          type: "line",
          toolbar: {
            show: false,
          },
          stacked: true,
          fontFamily: 'Nunito, sans-serif',
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [2, 1, 2],
          curve: "smooth",
        },
        grid: {
          borderColor: '#f1f1f1',
          strokeDashArray: 3
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: {
            show: false,
            color: 'rgba(119, 119, 142, 0.05)',
          },
          axisTicks: {
            show: false,
            color: 'rgba(119, 119, 142, 0.05)',
          },
          labels: {
            style: {
              colors: "#8c9097",
              fontSize: '11px',
              fontWeight: 600,
              cssClass: 'apexcharts-xaxis-label',
            },
          }
        },
        yaxis: {
          axisBorder: {
            show: false,
          },
        },
        legend: {
          show: true,
          position: "top",
          horizontalAlign: "center",
          fontSize: "11px",
          fontFamily: "Helvetica, Arial",
          fontWeight: 600,
          labels: {
            colors: '#74767c',
          },
          markers: {
            size:4,
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
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        colors: ["var(--primary-color)", "rgba(var(--primary-rgb),0.1)", "rgba(var(--secondary-rgb),1)"],
        plotOptions: {
          bar: {
            columnWidth: "25%",
            borderRadius: 4,
          }
        },
        fill: {
          opacity: [1, 0.05, 1],
          gradient: {
            inverseColors: false,
            shade: "light",
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100],
          },
        },
      };
      var chart1 = new ApexCharts(document.querySelector("#properties-statistics"), options1);
      chart1.render();
    /*  Properties Statistics */

    var options = {
      series: [{
          name: 'Visitors',
          data: [650, 770, 840, 890, 1100, 1380]
      }],
      chart: {
          height: 340,
          type: 'bar',
          events: {
              click: function (chart, w, e) {
              }
          },
          toolbar: {
              show: false,
          }
      },
      colors: ['var(--primary-color)', 'rgba(var(--secondary-rgb),1)', 'rgba(var(--success-rgb),1)', 'rgba(var(--warning-rgb),1)', 'rgba(var(--danger-rgb),1)', 'rgba(var(--pink-rgb),1)'],
      plotOptions: {
          bar: {
              barHeight: '40%',
              distributed: true,
              horizontal: true,
              borderRadius: 3,
          }
      },
      dataLabels: {
          enabled: false
      },
      legend: {
          show: false
      },
      grid: {
          borderColor: '#f1f1f1',
          strokeDashArray: 3
      },
      fill: {
          type: 'pattern',
          opacity: 1,
          pattern: {
              style: 'slantedLines', 
          }
      },
      xaxis: {
          categories: [
              "Apartment",
              "Villa",
              "Residency",
              "Penthouse",
              "Duplex",
              "Farm House",
          ],
          labels: {
              show: true,
              style: {
                  colors: "#adb5be",
                  fontSize: "12px",
                  fontWeight: 500,
                  cssClass: "apexcharts-xaxis-label",
              },
          },
      },
      yaxis: {
          labels: {
              show: true,
              style: {
                  colors: "#adb5be",
                  fontSize: "12px",
                  fontWeight: 500,
                  cssClass: "apexcharts-yaxis-label",
              },
          },
      },
      tooltip: {
          enabled: true,
          shared: false,
          intersect: true,
          x: {
              show: false
          },
          theme: "dark",
      },
  };
  var chart20 = new ApexCharts(document.querySelector("#property-by-category"), options);
  chart20.render();


  /* Visitors By Country Map */
var markers = [
  {
    name: "USA",
    coords: [40.3, -101.38],
  },
  {
        name: 'Greenland',
        coords: [72, -42],
    },
  {
    name: "Mauritius",
    coords: [-20.2, 57.5],
  }, 
    {
    name: "India",
    coords: [20.5937, 78.9629],
  }, 
  {
    name: "Vatican City",
    coords: [41.9, 12.45],
  },  
  {
    name: "Russia",
    coords: [61.5240, 105.3188],
    },
  {
    name: "Singapore",
    coords: [1.3, 103.8],
  },
{
    name: 'Brazil',
    coords: [-14.2350, -51.9253],
    style: {
        fill: '#000'
    }
},
];
var map = new jsVectorMap({
  map: "world_merc",
  selector: "#location-countries",
  markersSelectable: true,
  zoomOnScroll: false,
  zoomButtons: false,

  onMarkerSelected(index, isSelected, selectedMarkers) {
    console.log(index, isSelected, selectedMarkers);
  },

  // -------- Labels --------
  labels: {
    markers: {
      render: function (marker) {
        return marker.name;
      },
    },
  },

  regionStyle: {
    initial: {
      fill: 'rgba(var(--primary-rgb), 0.1)',
    },
  },

  // -------- Marker and label style --------
  markers: markers,
  markerStyle: {
    hover: {
      stroke: "var(--primary-color)",
      strokeWidth: 0,
      fill: "#FFF",
    },
    selected: {
      fill: "rgba(var(--success-rgb), 1)",
    },
  },
  markerLabelStyle: {
    initial: {
      fontFamily: "Poppins",
      fontSize: 13,
      fontWeight: 500,
      fill: "rgba(var(--success-rgb), 1)",
    },
  },
});
/* Visitors By Country Map */
  
  })();