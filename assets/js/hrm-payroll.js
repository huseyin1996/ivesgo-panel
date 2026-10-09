(function () {
    "use strict"

    const Statisticsoptions = {
      series: [
          {
              name: "Net Pay",
              data: [44, 42, 57, 86, 58, 55, 70, 43,],
          },
          {
              name: "Deduction",
              data: [74, 72, 87, 116, 88, 85, 100, 73],
          },
          {
              name: "Other",
              data: [84, 82, 97, 126, 98, 95, 110, 83],
          }
      ],
      chart: {
          stacked: true,
          type: "bar",
          height: 260,
      },
      grid: {
          borderColor: "#f5f4f4",
          strokeDashArray: 5,
          yaxis: {
              lines: {
                  show: true, // Ensure y-axis grids are shown
              },
          },
      },
      colors: [
          "var(--primary-color)",
          "var(--primary06)",
          "var(--primary03)",
      ],
      plotOptions: {
          bar: {
              columnWidth: "40%",
              borderRadius: 4
          },
      },
      dataLabels: {
          enabled: false,
      },
      legend: {
          show: true,
          position: "bottom",
          horizontalAlign: "center",
          fontSize: "11px",
          fontFamily: "Helvetica, Arial",
          fontWeight: 600,
          offsetX: 0,
          offsetY: 10,
          labels: {
              colors: '#74767c',
          },
          markers: {
              size: 4,
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
          title: {
              style: {
                  color: "#adb5be",
                  fontSize: "14px",
                  fontWeight: 600,
                  cssClass: "apexcharts-yaxis-label",
              },
          },
          axisBorder: {
              show: true,
              color: "rgba(119, 119, 142, 0.05)",
              offsetX: 0,
              offsetY: 0,
          },
          axisTicks: {
              show: true,
              borderType: "solid",
              color: "rgba(119, 119, 142, 0.05)",
              width: 6,
              offsetX: 0,
              offsetY: 0,
          },
          labels: {
              formatter: function (y) {
                  return y.toFixed(0) + "k";
              },
          },
      },
      xaxis: {
          type: "month",
          categories: [
              "Accounts",
              "HR",
              "Design",
              "Develop",
              "IT",
              "Marketing",
              "Testing",
              "Other",
          ],
          axisBorder: {
              show: false,
              color: "rgba(119, 119, 142, 0.05)",
              offsetX: 0,
              offsetY: 0,
          },
          axisTicks: {
              show: false,
              borderType: "solid",
              color: "rgba(119, 119, 142, 0.05)",
              width: 6,
              offsetX: 0,
              offsetY: 0,
          },
          labels: {
              rotate: -90,
          },
      },
  };
  const Statisticschart = new ApexCharts(document.querySelector("#pay-by-department"), Statisticsoptions);
  if(Statisticschart) Statisticschart.render();

  const options1 = {
    series: [{
        name: 'Last Year',
        type: "line",
        data: [30, 25, 36, 30, 45, 35, 64, 51, 59, 36, 39, 51]
    }],
    chart: {
        height: 260,
        type: 'line',
        stacked: !1,
        toolbar: {
            show: !1
        },
        dropShadow: {
            enabled: true,
            enabledOnSeries: undefined,
            top: 6,
            left: 0,
            blur: 0,
            color: 'rgba(var(--secondary-rgb),1)',
            opacity: 0.05
        },
    },
    grid: {
        borderColor: '#f2f6f7',
        strokeDashArray: 2,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: false
            }
        }
    },
    dataLabels: {
        enabled: false
    },
    colors: ["rgba(var(--secondary-rgb),1)"],
 
    stroke: {
        width: [1.75],
        curve: "smooth",
        dashArray: [0]
    },
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    legend: {
        show: true,
        position: 'top'
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return value + "k";
        }
      }
    },
    tooltip: {
        enabled: true,
        theme: "dark",
    }
};
const chart1 = new ApexCharts(document.querySelector("#monthly-payroll"), options1);
if(chart1) chart1.render();

 /* To choose date */
 flatpickr("#date", {disableMobile: true});

 new gridjs.Grid({
  columns: [

    // Employee
    {
      name: "Employee",
      width: "260px",
      formatter: (cell) => gridjs.html(`
        <div class="d-flex align-items-center gap-2">
          <span class="avatar avatar-sm avatar-rounded bg-light">
            <img src="${cell.image}" alt="${cell.name}" class="avatar-img">
          </span>
          <div>
            <span class="d-block fw-semibold">${cell.name}</span>
            <span class="fs-13 text-muted">${cell.empId}</span>
          </div>
        </div>
      `)
    },

    { name: "Department", width: "120px" },

    { name: "Base Salary", width: "120px" },

    {
      name: "Bonus",
      width: "100px",
      formatter: (cell) => gridjs.html(`
        <span class="text-success fw-semibold">${cell}</span>
      `)
    },

    {
      name: "Deductions",
      width: "120px",
      formatter: (cell) => gridjs.html(`
        <span class="text-danger fw-semibold">${cell}</span>
      `)
    },

    {
      name: "Net Pay",
      width: "120px",
      formatter: (cell) => gridjs.html(`
        <span class="fw-bold">${cell}</span>
      `)
    },

    {
      name: "Status",
      width: "120px",
      formatter: (cell) => {
        let badge = "success";
        if (cell === "Pending") badge = "warning";
        if (cell === "Unpaid") badge = "danger";

        return gridjs.html(`
          <span class="badge bg-${badge}-transparent">${cell}</span>
        `);
      }
    },

    {
      name: "Actions",
      width: "100px",
      formatter: () => gridjs.html(`
        <div class="dropdown custom-invoice">
          <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light border" data-bs-toggle="dropdown">
            <i class="fe fe-more-vertical"></i>
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="javascript:void(0);">
                <i class="ri-eye-line me-2"></i>View Payslip
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="javascript:void(0);">
                <i class="ri-download-line me-2"></i>Download
              </a>
            </li>
            <li>
              <a class="dropdown-item text-danger" href="javascript:void(0);">
                <i class="ri-delete-bin-line me-2"></i>Delete
              </a>
            </li>
          </ul>
        </div>
      `)
    }

  ],

  data: [
    [
      { name: "Arjun Reddy", empId: "#EMP-1384", image: "../assets/images/faces/14.jpg" },
      "HR",
      "$3,000",
      "$500",
      "$200",
      "$3,300",
      "Paid"
    ],
    [
      { name: "Meera Sharma", empId: "#EMP-1385", image: "../assets/images/faces/8.jpg" },
      "Finance",
      "$2,800",
      "$300",
      "$150",
      "$2,950",
      "Pending"
    ],
    [
      { name: "Ravi Kumar", empId: "#EMP-1386", image: "../assets/images/faces/11.jpg" },
      "IT",
      "$4,000",
      "$800",
      "$400",
      "$4,400",
      "Paid"
    ],
    [
      { name: "Priya Nair", empId: "#EMP-1387", image: "../assets/images/faces/12.jpg" },
      "Marketing",
      "$2,500",
      "$200",
      "$100",
      "$2,600",
      "Paid"
    ],
    [
      { name: "Suresh Babu", empId: "#EMP-1388", image: "../assets/images/faces/13.jpg" },
      "Operations",
      "$3,200",
      "$400",
      "$250",
      "$3,350",
      "Pending"
    ],
    [
      { name: "Anita Das", empId: "#EMP-1389", image: "../assets/images/faces/2.jpg" },
      "Admin",
      "$2,600",
      "$150",
      "$100",
      "$2,650",
      "Paid"
    ],
    [
      { name: "Kiran Patel", empId: "#EMP-1382", image: "../assets/images/faces/4.jpg" },
      "IT",
      "$3,500",
      "$600",
      "$300",
      "$3,800",
      "Paid"
    ],
    [
      { name: "Deepa Iyer", empId: "#EMP-1383", image: "../assets/images/faces/5.jpg" },
      "Finance",
      "$2,900",
      "$250",
      "$180",
      "$2,970",
      "Unpaid"
    ],
    [
      { name: "Vikram Singh", empId: "#EMP-1390", image: "../assets/images/faces/6.jpg" },
      "Sales",
      "$3,100",
      "$450",
      "$200",
      "$3,350",
      "Paid"
    ],
    [
      { name: "Neha Verma", empId: "#EMP-1391", image: "../assets/images/faces/7.jpg" },
      "Marketing",
      "$2,700",
      "$300",
      "$120",
      "$2,880",
      "Paid"
    ]
  ],

  style: {
    table: {
      "white-space": "nowrap"
    }
  },

  pagination: false,
  sort: true,
  search: false
}).render(document.getElementById("grid-payroll"));

})()