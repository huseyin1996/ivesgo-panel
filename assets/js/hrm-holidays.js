(function () {
  "use strict";

     /* To choose date */
     flatpickr("#date", {disableMobile: true});
     flatpickr("#date-1", {disableMobile: true});

  new gridjs.Grid({
    columns: [
      {
        id: "select",
        name: gridjs.html(`
          <input class="form-check-input" type="checkbox">
        `),
        width: "50px",
        sort: false,
        formatter: () => gridjs.html(`
          <input class="form-check-input" type="checkbox">
        `)
      },

      {
        name: "Holiday Name",
        width: "220px"
      },

      {
        name: "Date",
        width: "120px"
      },

      {
        name: "Day",
        width: "100px"
      },

      {
        name: "Description",
        width: "280px"
      },

      {
        name: "Status",
        width: "120px",
        formatter: (cell) => {
          let cls = "success";

          if (cell === "Inactive") cls = "danger";
          if (cell === "Upcoming") cls = "warning";

          return gridjs.html(
            `<span class="badge bg-${cls}-transparent">${cell}</span>`
          );
        }
      },

      {
        name: "Created On",
        width: "130px"
      },

      {
        name: "Optional",
        width: "100px",
        formatter: (cell) =>
          gridjs.html(
            cell
              ? '<span class="text-success fw-medium">Yes</span>'
              : '<span class="text-danger fw-medium">No</span>'
          )
      },

      {
        name: "Added By",
        width: "150px"
      },

      {
        name: "Actions",
        width: "120px",
        sort: false,
        formatter: () => gridjs.html(`
          <div class="dropdown">
            <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
              <i class="fe fe-more-vertical"></i>
            </button>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="ri-eye-line me-2"></i>View
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="ri-edit-line me-2"></i>Edit
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
        "",
        "New Year's Day",
        "Jan 01, 2025",
        "Friday",
        "Celebration of the beginning of the new year.",
        "Active",
        "Dec 15, 2024",
        false,
        "Admin"
      ],
      [
        "",
        "Republic Day",
        "Jan 26, 2025",
        "Sunday",
        "National holiday celebrating the Constitution of India.",
        "Active",
        "Dec 18, 2024",
        false,
        "HR Team"
      ],
      [
        "",
        "Holi",
        "Mar 14, 2025",
        "Friday",
        "Festival of colors celebrated across India.",
        "Upcoming",
        "Jan 10, 2025",
        true,
        "Priya Sharma"
      ],
      [
        "",
        "Independence Day",
        "Aug 15, 2025",
        "Friday",
        "Commemorates India's independence.",
        "Upcoming",
        "Jan 15, 2025",
        false,
        "Admin"
      ],
      [
        "",
        "Diwali",
        "Oct 20, 2025",
        "Monday",
        "Festival of lights celebrated nationwide.",
        "Upcoming",
        "Feb 05, 2025",
        true,
        "HR Team"
      ],
      [
        "",
        "Christmas Day",
        "Dec 25, 2025",
        "Thursday",
        "Annual Christian holiday celebrating the birth of Jesus Christ.",
        "Upcoming",
        "Mar 12, 2025",
        true,
        "John Mathew"
      ],
      [
        "",
        "Gandhi Jayanti",
        "Oct 02, 2025",
        "Saturday",
        "National holiday commemorating the birth anniversary of Mahatma Gandhi.",
        "Active",
        "Feb 20, 2025",
        false,
        "Admin"
      ]
    ],

    pagination: false,
    sort: false,
    search: false
  }).render(document.getElementById("grid-holiday-list"));

})();