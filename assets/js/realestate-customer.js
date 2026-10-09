(function () {
  "use strict"

  // Sample Data
  const productsData = [
      ['#SPK001', 'Alice Johnson', '../assets/images/faces/2.jpg', 'New York, NY', 'Active', '555-123-4567', 'alice.johnson@email.com', 'Join on Mar 12, 2025','Apartment'],
      ['#SPK002', 'Bob Smith', '../assets/images/faces/3.jpg', 'Los Angeles, CA', 'Inactive', '555-234-5678', 'bob.smith@email.com', 'Join on Mar 10, 2025','Villa'],
      ['#SPK003', 'Carol Davis', '../assets/images/faces/4.jpg', 'Chicago, IL', 'Active', '555-345-6789', 'carol.davis@email.com', 'Join on Mar 5, 2025','Land'],
      ['#SPK004', 'David Lee', '../assets/images/faces/6.jpg', 'Houston, TX', 'Active', '555-456-7890', 'david.lee@email.com', 'Join on Mar 2, 2025','Commercial'],
      ['#SPK005', 'Emma Wilson', '../assets/images/faces/8.jpg', 'San Francisco, CA', 'Active', '555-567-8901', 'emma.wilson@email.com', 'Join on Feb 28, 2025','Apartment'],
      ['#SPK006', 'Alice Johnson', '../assets/images/faces/9.jpg', 'Indianapolis, IN', 'Inactive', '555-678-9012', 'alice.Johnason@email.com', 'Join on Feb 25, 2025','Villa'],
      ['#SPK007', 'Frank Moore', '../assets/images//faces/12.jpg', 'Washington, DC', 'Active', '555-789-0123', 'frank.moore@email.com', 'Join on Feb 20, 2025','Land'],
      ['#SPK008', 'Jack Walker', '../assets/images/faces/1.jpg', 'Las Vegas, NV', 'Active', '555-890-1234', 'jack.walker@email.com', 'Join on Feb 18, 2025','Apartment'],
      ['#SPK009', 'Grace Taylor', '../assets/images//faces/11.jpg', 'Baltimore, MD', 'Active', '555-901-2345', 'grace.taylor@email.com', 'Join on Feb 15, 2025','Commercial'],
      ['#SPK010', 'Isabella Lewis', '../assets/images/faces/13.jpg', 'Memphis, TN', 'Inactive', '555-012-3456', 'isabella.lewis@email.com', 'Join on Feb 10, 2025','Villa']
  ];

  const grid = new gridjs.Grid({
      columns: [
          {
              name: '#',
              formatter: (_, row) => gridjs.html(
                  `<input class="form-check-input" type="checkbox" id="product-${row.cells[0].data}" value="" aria-label="...">`
              )
          },
          {
              name: 'Customer ID',
              formatter: (_, row) => gridjs.html(
                  `<a href="javascript:void(0);">${row.cells[0].data}</a>`  // Correctly map to Product ID (row[0])
              )
          },
          {
              name: 'Customer Name',
              formatter: (_, row) => gridjs.html(
                  `<a href="product-details.html">
                      <div class="d-flex align-items-center gap-3 position-relative">
                          <div class="lh-1">
                              <span class="avatar avatar-lg bg-light p-1">
                                  <img src="${row.cells[2].data}" alt="Product Image">
                              </span>
                          </div>
                          <div>
                              <span class="d-block fw-semibold">${row.cells[1].data}</span>
                              <span class="text-muted fs-13">${row.cells[7].data}</span>
                          </div>
                      </div>
                  </a>`
              )
          },
          {
            name:  'Location',
            formatter: (_, row) => gridjs.html(
                `<span><i class="ri-map-pin-line text-muted"></i> ${row.cells[3].data}</span>` // Correctly map to Quantity (row[6])
            )
          },
          {
              name: 'Status',
              formatter: (_, row) => gridjs.html(
                  `<span class="badge bg-${row.cells[4].data === 'Active' ? 'success' : 'danger'}-transparent">${row.cells[4].data}</span>`
              )
          },
          {
              name: 'Phone Number',
              formatter: (_, row) => gridjs.html(
                  `<span><i class="ri-phone-line text-muted"></i> ${row.cells[5].data}</span>` // Correctly map to Quantity (row[6])
              )
          },
          {
            name: 'Email ID',
            formatter: (_, row) => gridjs.html(
                `<span><i class="ri-mail-line text-muted"></i> ${row.cells[6].data}</span>` // Correctly map to Quantity (row[6])
            )
        },
        {
          name:  'Property Interest',
          formatter: (_, row) => gridjs.html(
              `${row.cells[8].data}` // Correctly map to Quantity (row[6])
          )
        },
         
          {
              name: 'Actions',
              formatter: (_, row) => gridjs.html(`
                  <div class="dropdown">
                      <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light border" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fe fe-more-vertical"></i>
                      </a>
                      <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="product-details.html"><i class="ri-eye-line me-2"></i>View</a></li>
                          <li><a class="dropdown-item btn-delete" href="javascript:void(0);"><i class="ri-delete-bin-line me-2"></i>Delete</a></li>
                      </ul>
                  </div>
              `)
          }
      ],
      data: productsData,
      pagination: true,
      search: false,
      sort: true
  }).render(document.getElementById('product-table'));

  // Add a listener for delete actions in the table with SweetAlert confirmation
  document.addEventListener('click', function (e) {
      if (e.target && e.target.classList.contains('btn-delete')) {
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  // Find the row index of the product to delete
                  const rowIndex = e.target.closest('tr').rowIndex - 1; // Subtract 1 to account for the header row

                  // Remove the product from the productsData array
                  productsData.splice(rowIndex, 1);

                  // Update the grid with the new data
                  grid.updateConfig({
                      data: productsData
                  }).forceRender();

                  Swal.fire(
                      'Deleted!',
                      'Your product has been deleted.',
                      'success'
                  );
              }
          });
      }
  });

})();