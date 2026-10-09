(function () {
    "use strict"


    new gridjs.Grid({
      columns: [
    
        {
          name: "Employee",
          width: "260px",
          formatter: (cell) => gridjs.html(`
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm avatar-rounded bg-light">
                <img src="${cell.image}" class="avatar-img">
              </span>
              <div>
                <span class="d-block fw-semibold">${cell.name}</span>
                <span class="fs-13 text-muted">${cell.empId}</span>
              </div>
            </div>
          `)
        },
    
        { name: "Department", width: "120px" },
        { name: "Leave Type", width: "130px" },
         /* PRIORITY */
         {
          name: "Priority",
          width: "110px",
          formatter: (cell) => {
            let cls = "success";
            if (cell === "High") cls = "danger";
            if (cell === "Medium") cls = "warning";
            return gridjs.html(`<span class="badge bg-${cls}-transparent">${cell}</span>`);
          }
        },
        
        { name: "From", width: "100px" },
        { name: "To", width: "100px" },
    
       
        /* STATUS */
        {
          name: "Status",
          width: "120px",
          formatter: (cell) => {
            let cls = "warning";
            if (cell === "Approved") cls = "success";
            if (cell === "Rejected") cls = "danger";
            return gridjs.html(`<span class="badge bg-${cls}-transparent">${cell}</span>`);
          }
        },
    
        /* ACTIONS */
        {
          name: "Actions",
          width: "120px",
          formatter: () => gridjs.html(`
            <div class="dropdown">
              <button class="btn btn-light btn-sm border" data-bs-toggle="dropdown">
                <i class="fe fe-more-vertical"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-line me-2"></i>View</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-check-line me-2"></i>Approve</a></li>
                <li><a class="dropdown-item text-danger" href="javascript:void(0);"><i class="ri-close-line me-2"></i>Reject</a></li>
              </ul>
            </div>
          `)
        }
    
      ],
    
      data: [
        [
          { name: "Arjun Reddy", empId: "#EMP-1384", image: "../assets/images/faces/14.jpg" },
          "HR",
          "Annual",
          "High",
          "Jul 10",
          "Jul 12",
          "Approved"
        ],
        [
          { name: "Meera Sharma", empId: "#EMP-1385", image: "../assets/images/faces/8.jpg" },
          "Finance",
          "Sick",
          "Medium",
          "Jul 08",
          "Jul 09",
          "Pending"
        ],
        [
          { name: "Neha Verma", empId: "#EMP-1391", image: "../assets/images/faces/11.jpg" },
          "Marketing",
          "Casual",
          "Low",
          "Jul 14",
          "Jul 22",
          "Approved"
        ],
        [
          { name: "Kiran Patel", empId: "#EMP-1382", image: "../assets/images/faces/4.jpg" },
          "IT",
          "Sick",
          "High",
          "Jul 13",
          "Jul 16",
          "Rejected"
        ],
        [
          { name: "Deepa Iyer", empId: "#EMP-1383", image: "../assets/images/faces/5.jpg" },
          "Finance",
          "Annual",
          "Low",
          "Jul 12",
          "Jul 19",
          "Pending"
        ],
        [
          { name: "Suresh Babu", empId: "#EMP-1388", image: "../assets/images/faces/13.jpg" },
          "Operations",
          "Annual",
          "High",
          "Jul 15",
          "Jul 17",
          "Pending"
        ],
      ],
    
      pagination: false,
      sort: true,
      search: false
    }).render(document.getElementById("grid-total-leaves"));

    new gridjs.Grid({
      columns: [
    
        {
          name: "Employee",
          width: "260px",
          formatter: (cell) => gridjs.html(`
            <div class="d-flex align-items-center gap-2">
              <span class="avatar avatar-sm avatar-rounded bg-light">
                <img src="${cell.image}" class="avatar-img">
              </span>
              <div>
                <span class="d-block fw-semibold">${cell.name}</span>
                <span class="fs-13 text-muted">${cell.empId}</span>
              </div>
            </div>
          `)
        },
    
        { name: "Department", width: "120px" },
        { name: "Leave Type", width: "130px" },
    
        /* PRIORITY */
        {
          name: "Priority",
          width: "110px",
          formatter: (cell) => {
            let cls = "success";
            if (cell === "High") cls = "danger";
            if (cell === "Medium") cls = "warning";
            return gridjs.html(`<span class="badge bg-${cls}-transparent">${cell}</span>`);
          }
        },
    
        { name: "Request Dates", width: "120px" },
        /* STATUS */
        { name: "Duration", width: "130px" },
    
        /* ACTIONS */
        {
          name: "Actions",
          width: "120px",
          formatter: () => gridjs.html(`
            <div class="d-flex gap-2 flex-wrap">
               <button class="btn btn-sm btn-success-light">Approve</button>
               <button class="btn btn-sm btn-danger-light">Reject</button>
            </div>
          `)
        }
    
      ],
    
      data: [
        [
          { name: "Meera Sharma", empId: "#EMP-1385", image: "../assets/images/faces/8.jpg" },
          "Finance",
          "Sick",
          "Medium",
          "Jul 08 - Jun 14",
          "6 Days",
        ],
        [
          { name: "Neha Verma", empId: "#EMP-1391", image: "../assets/images/faces/11.jpg" },
          "Marketing",
          "Casual",
          "Low",
          "Jul 14 - Aug 14",
          "1 Month",
        ],
        [
          { name: "Deepa Iyer", empId: "#EMP-1383", image: "../assets/images/faces/5.jpg" },
          "Finance",
          "Annual",
          "Low",
          "Jul 12 - Jul 17",
          "5 Days",
        ],
      ],
    
      pagination: false,
      sort: true,
      search: false
    }).render(document.getElementById("grid-requested-leaves"));

})()