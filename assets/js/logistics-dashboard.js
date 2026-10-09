var options = {
    series: [75.8],
    chart: {
        type: 'radialBar',
        height: 234
    },
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            hollow: {
                size: '60%'
            },
            track: {
                background: 'rgba(var(--primary-rgb), .2)',
                strokeWidth: '97%'
            },
            dataLabels: {
                show: false
            }
        }
    },
    stroke: {
        dashArray: 4,
    },
    colors: ['rgba(var(--primary-rgb), 1)'],
};

var chart = new ApexCharts(
    document.querySelector("#deliveryChart"),
    options
);

chart.render();



var options = {
  // series: [
  //   {
  //       type: "area",
  //     name: "Shipping",
  //     data: [150, 180, 220, 120, 140, 110, 180, 90, 130, 170, 120, 160]
  //   },
  //   {
  //       type: "line",
  //     name: "Returns",
  //     data: [170, 200, 240, 150, 170, 150, 220, 120, 160, 200, 160, 190]
  //   }
  // ],
  series: [
  {
    name: "Shipments",
    type: "area",
    data: [170, 200, 240, 150, 170, 150, 220, 120, 160, 200, 160, 190]
  },
  {
    name: "Delivered",
    type: "line",
    data:  [150, 180, 220, 120, 140, 110, 180, 90, 130, 170, 120, 160]
  },
  {
    name: "Returned",
    type: "bar",
    data: [20,25,22,18,21,17,23,15,18,20,17,19]
  }
  ],

  chart: {
    type: "bar",
    height: 268,
    stacked: true,
    toolbar: {
      show: false
    }
  },

  colors: ["rgba(var(--primary-rgb), .1)", "rgba(var(--primary-rgb), 1)", "rgba(var(--success-rgb), 1)"],

  plotOptions: {
    bar: {
      columnWidth: "15%",
      borderRadius: 2
    }
  },

  markers: {
    size: [0, 2, 0],
    colors: ["#fff"],
    strokeColor: ["rgba(var(--primary-rgb), .1)", "rgba(var(--primary-rgb), 1)", "rgba(var(--success-rgb), 1)"],
    strokeWidth: 2
},

  dataLabels: {
    enabled: false
  },
  grid: {
    borderColor: '#edf1f5',
    strokeDashArray: 4
},

  stroke: {
    width: [2, 2],
    dashArray: [0, 3]
  },

  xaxis: {
    categories: [
      "Jan","Feb","Mar","Apr",
      "May","Jun","Jul","Aug",
      "Sep","Oct","Nov","Dec"
    ]
  },

  yaxis: {
    min: 50,
    max: 250,
    tickCount: 3
  },

  legend: {
    shape: 'circle',
    markers: {
        size: 4,
         shape: 'circle',
    }
    // show: false
  }
};

new ApexCharts(
  document.querySelector("#shippingChart"),
  options
).render();

///maps


// LIGHT MAP STYLE
const map = L.map('logistics-map', {
    zoomControl:false
}).setView([52.2, 11.0], 6);

// OpenStreetMap LIGHT
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: ''
// }).addTo(map);
L.tileLayer(
    'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
    {
        subdomains: 'abcd',
        maxZoom: 20,
        attribution: ''
    }
).addTo(map);

// COORDS
const start = [53.5511, 9.9937];   // Hamburg
const end = [52.5200, 13.4050];    // Berlin
const truck = [52.8, 11.3];

// START (RED CUSTOM PIN)
const startIcon = L.divIcon({
    className: '',
    html: `<div class="start-pin"></div>`,
    iconSize: [10,10]
});

// END = DEFAULT LEAFLET PIN (NO CUSTOM ICON)
const endMarker = L.marker(end)
    .addTo(map)
    .bindPopup("Destination");

// TRUCK ICON (TABLER STYLE SVG)
const truckIcon = L.divIcon({
    className: '',
    html: `
    <div class="truck-icon">
        <svg xmlns="http://www.w3.org/2000/svg"
            width="18" height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke="rgba(var(--primary-rgb), 1)"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M3 7h12v10H3z"/>
            <path d="M15 9h4l2 3v5h-6z"/>
            <circle cx="7" cy="17" r="2"/>
            <circle cx="17" cy="17" r="2"/>
        </svg>
    </div>`,
    iconSize: [20,20]
});

// MARKERS
L.marker(start, {icon: startIcon})
    .addTo(map)
    .bindPopup("Warehouse");

L.marker(truck, {icon: truckIcon})
    .addTo(map)
    .bindPopup("Truck");

// ROUTE LINE
L.polyline([start, truck, end], {
    color:'rgba(var(--primary-rgb), 1)',
    weight:3,
    opacity:0.9,
    dashArray:'6 6'
}).addTo(map);

// FIT VIEW
map.fitBounds([start,end], {
    padding:[10,10]
});

// function createMiniChart(selector, color, data) {
//     var options = {
//         series: [{
//             data: data
//         }],
//         chart: {
//             type: 'area',
//             height: 60,
//             sparkline: {
//                 enabled: true
//             },
//             toolbar: {
//                 show: false
//             }
//         },
//         plotOptions: {
//             bar: {
//                 borderRadius: 3,
//                 columnWidth: '35%'
//             }
//         },
//         colors: [color],
//         dataLabels: {
//             enabled: false
//         },
//         stroke: {
//             width: .1,
//             curve: 'smooth',
//             dashArray: [0]
//         },
//         tooltip: {
//             enabled: true
//         },
//         grid: {
//             show: false
//         },
//         xaxis: {
//             crosshairs: {
//                 show: false
//             }
//         },
//         yaxis: {
//             show: false
//         }
//     };

//     new ApexCharts(document.querySelector(selector), options).render();
// }

// // Total Shipments
// createMiniChart(
//     "#shipmentChart",
//     "#845ADF",
//     [5, 10, 6, 15, 8, 12, 6]
// );

// // Delivered Orders
// createMiniChart(
//     "#deliveredChart",
//     "#23B7E5",
//     [5, 10, 6, 15, 8, 12, 6]
// );

// // In Transit
// createMiniChart(
//     "#transitChart",
//     "#26BF94",
//     [5, 10, 6, 15, 8, 12, 6]
// );

// // Delayed
// createMiniChart(
//     "#delayedChart",
//     "#F5B849",
//     [5, 10, 6, 15, 8, 12, 6]
// );


/* fleetChart */

  var options = {
  series: [
    {
        data: [180, 320, 220]
    },
  ],

  chart: {
    type: 'bar',
    height: 195,
    stacked:  false,
    toolbar: {
      show: false
    }
  },
   fill: {
    type: 'pattern',
    pattern: {
      style: ['slantedLines', 'slantedLines', 'slantedLines'],
      strokeWidth: 1.5
    }
  },

  plotOptions: {
    bar: {
      horizontal: true,
      barHeight: '48%',
      borderRadius: 5,
      distributed: true,
      colors: {
      backgroundBarColors: [
        'rgba(var(--primary-rgb), 0.2)',
        'rgba(var(--success-rgb), 0.2)',
        'rgba(var(--warning-rgb), 0.2)'
      ],
      backgroundBarOpacity: 1
    }
    }
  }, stroke: {
        dashArray: 4,
    },

  legend: {
    show: false,
    position: 'bottom',
    fontSize: '10px',
    markers: {
      size: 5,
      shape: 'circle'
    },
    labels: {
        fontSize: '10px',
    },

  },

  dataLabels: {
    enabled: false
  },

  grid: {
    borderColor: '#ffffff',
    strokeDashArray: 5,
    xaxis: {
      lines: {
        show: false
      }
    },
  },

  colors: [
    "rgba(var(--primary-rgb), 1)",
    "rgba(var(--success-rgb), 1)",
    "rgba(var(--warning-rgb), .8)"
  ],

  xaxis: {
    categories: ['On Route','Completed','Delayed'],
     max: 500,

    axisBorder: {
      show: true,
      color: '#c7cacd'
    },

    axisTicks: {
      show: true,
      borderType: 'solid',
      color: '#c7cacd',
      width: 6
    },
  },
  stroke: {
    width: 0,
  },

  tooltip: {
    theme: "dark"
  }
};


new ApexCharts(
    document.querySelector("#fleetChart"),
    options
).render();
/* fleetChart */

var options = {

    chart: {
        height: 267,
        type: 'scatter',
        toolbar: {
            show:false
        },
        zoom:{
            enabled:false
        }
    },

    series: [
        {
            name: "Occupied Capacity",
            data: [
                [1,18],
                [2,28],
                [3,24],
                [4,36],
                [5,30],
                [6,26]
            ]
        },
        {
            name: "Available Capacity",
            data: [
                [1,9],
                [2,14],
                [3,18],
                [4,22],
                [5,20],
                [6,32]
            ]
        }
    ],

    colors:['rgba(var(--primary-rgb), 1)','rgba(var(--success-rgb), .75)'],

    markers:{
        size:18,
        shape:"square",
        strokeWidth:0,
        hover:{
            size:20
        }
    },

    grid:{
        borderColor:'#edf2f7',
        strokeDashArray:4
    },

    dataLabels:{
        enabled:false
    },

    legend:{
        show:false
    },

    xaxis:{
        categories:[
            'Jan',
            'Mar',
            'May',
            'Jul',
            'Sep',
            'Dec'
        ],
    },

    yaxis:{
        min:0,
    },

};

new ApexCharts(
    document.querySelector("#capacityChart"),
    options
).render();



function createProgressChart(el, value, color) {
    new ApexCharts(document.querySelector(el), {
        chart: {
            type: 'radialBar',
            height: 56,
            width: 56,
            sparkline: {
                enabled: true
            }
        },
        series: [value],
        colors: [color],
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '35%'
                },
                track: {
                    background: '#f1f3f7'
                },
                dataLabels: {
                    name: {
                        show: false
                    },
                    value: {
                        fontSize: '10px',
                        fontWeight: 600,
                        offsetY: 4,
                        formatter: function(val) {
                            return parseInt(val) + '%';
                        }
                    }
                }
            }
        },
        stroke: {
            lineCap: 'round'
        }
    }).render();
}

createProgressChart('#truck-progress-1', 90, 'rgba(var(--success-rgb), 1)');
createProgressChart('#truck-progress-2', 50, 'rgba(var(--warning-rgb), 1)');
createProgressChart('#truck-progress-3', 75, 'rgba(var(--primary-rgb), 1)');
createProgressChart('#truck-progress-4', 65, 'rgba(var(--warning-rgb), 1)');