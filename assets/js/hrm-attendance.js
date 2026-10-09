(function () {
    "use strict"

       /* To choose date */
       flatpickr("#date", {disableMobile: true});
       flatpickr("#att-date", {disableMobile: true});
       /* For Time Picker */
        flatpickr("#timepikcr1", {
          enableTime: true,
          noCalendar: true,
          dateFormat: "H:i",
          disableMobile: true
      });
      /* For Time Picker */
      flatpickr("#timepikcr2", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        disableMobile: true
    });

       new gridjs.Grid({
        columns: [
            
          {
            name: "Employee",
            width: "280px",
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
      
          { name: "Department", width: "130px" },

          { name: "Shift Type", width: "130px" },
      
          {
            name: "Check-In",
            width: "140px",
            formatter: (cell) => gridjs.html(`
              <div><i class="ti ti-clock-hour-8 text-muted me-1"></i> ${cell}</div>
            `)
          },
      
          {
            name: "Check-Out",
            width: "140px",
            formatter: (cell) => gridjs.html(`
              <div><i class="ti ti-clock-hour-4 text-muted me-1"></i> ${cell}</div>
            `)
          },
      
          { name: "Total Hours", width: "120px" },
      
          {
            name: "Status",
            width: "130px",
            formatter: (cell) => {
              let badge = "success";
              if (cell === "Absent") badge = "danger";
              if (cell === "Pending") badge = "warning";
      
              return gridjs.html(`
                <span class="badge bg-${badge}-transparent">${cell}</span>
              `);
            }
          },
      
          { name: "Marked By", width: "120px" },
      
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
                      <i class="ri-eye-line me-2"></i>View
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="ri-checkbox-circle-line me-2"></i>Mark
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
            "General Shift",
            "09:05 AM",
            "06:10 PM",
            "9h 05m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Meera Sharma", empId: "#EMP-1385", image: "../assets/images/faces/8.jpg" },
            "Finance",
            "Morning Shift",
            "09:20 AM",
            "06:00 PM",
            "8h 40m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Ravi Kumar", empId: "#EMP-1386", image: "../assets/images/faces/11.jpg" },
            "IT",
            "Morning Shift",
            "--",
            "--",
            "0h 00m",
            "Absent",
            "Employee"
          ],
          [
            { name: "Priya Nair", empId: "#EMP-1387", image: "../assets/images/faces/12.jpg" },
            "Marketing",
            "Night Shift",
            "09:00 AM",
            "05:45 PM",
            "8h 45m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Suresh Babu", empId: "#EMP-1388", image: "../assets/images/faces/13.jpg" },
            "Operations",
            "General Shift",
            "09:10 AM",
            "--",
            "6h 30m",
            "Pending",
            "Admin"
          ],
          [
            { name: "Anita Das", empId: "#EMP-1389", image: "../assets/images/faces/2.jpg" },
            "Admin",
            "Morning Shift",
            "08:55 AM",
            "05:50 PM",
            "8h 55m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Kiran Patel", empId: "#EMP-1382", image: "../assets/images/faces/4.jpg" },
            "IT",
            "Afternoon Shift",
            "09:30 AM",
            "06:15 PM",
            "8h 45m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Deepa Iyer", empId: "#EMP-1383", image: "../assets/images/faces/5.jpg" },
            "Finance",
            "Night Shift",
            "--",
            "--",
            "0h 00m",
            "Absent",
            "Admin"
          ],
          [
            { name: "Vikram Singh", empId: "#EMP-1390", image: "../assets/images/faces/6.jpg" },
            "Sales",
            "General Shift",
            "09:15 AM",
            "06:05 PM",
            "8h 50m",
            "Present",
            "Biometric"
          ],
          [
            { name: "Neha Verma", empId: "#EMP-1391", image: "../assets/images/faces/7.jpg" },
            "Marketing",
            "Morning Shift",
            "09:05 AM",
            "05:55 PM",
            "8h 50m",
            "Present",
            "Biometric"
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
      }).render(document.getElementById("grid-attendance"));

})()