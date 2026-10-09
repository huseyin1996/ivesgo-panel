(function () {
  "use strict"

// Sample Agent Data
const agentsData = [
    ['#AG001', 'Michael Brown','../assets/images/faces/2.jpg', 'Active', 'Join on Mar 12, 2025', 'New York, NY', 'Residential', '8 Years', '3%'],
    ['#AG002', 'Sarah Wilson', '../assets/images/faces/3.jpg', 'Active', 'Join on Mar 10, 2025', 'Los Angeles, CA', 'Commercial', '10 Years', '4%'],
    ['#AG003', 'James Taylor', '../assets/images/faces/4.jpg', 'Inactive', 'Join on Mar 5, 2025', 'Chicago, IL', 'Villas', '6 Years', '2.5%'],
    ['#AG004', 'Emily Davis',  '../assets/images/faces/6.jpg', 'Active', 'Join on Mar 2, 2025', 'Houston, TX', 'Apartments', '4 Years', '3%'],
    ['#AG005', 'Daniel Martinez',  '../assets/images/faces/8.jpg', 'Pending', 'Join on Feb 28, 2025', 'San Francisco, CA', 'Land Sales', '2 Years', '2%'],
    ['#AG006', 'Olivia Anderson', '../assets/images/faces/9.jpg', 'Active', 'Join on Feb 25, 2025', 'Philadelphia, PA', 'Luxury Homes', '12 Years', '5%'],
    ['#AG007', 'William Thomas', '../assets/images//faces/12.jpg', 'Active', 'Join on Feb 20, 2025', 'San Antonio, TX', 'Residential', '7 Years', '3%'],
    ['#AG008', 'Sophia Jackson', '../assets/images/faces/1.jpg', 'Inactive', 'Join on Feb 18, 2025', 'San Diego, CA', 'Commercial', '9 Years', '4%'],
    ['#AG009', 'Benjamin White', '../assets/images//faces/11.jpg', 'Active', 'Join on Feb 15, 2025', 'Dallas, TX', 'Apartments', '5 Years', '2.5%'],
    ['#AG010', 'Ava Harris', '../assets/images/faces/13.jpg', 'Active', 'Join on Feb 10, 2025', 'San Jose, CA', 'Villas', '3 Years', '3%']
];

const grid = new gridjs.Grid({
    columns: [
        {
            name: '#',
            formatter: (_, row) => gridjs.html(
                `<input class="form-check-input" type="checkbox" id="agent-${row.cells[0].data}" value="" aria-label="...">`
            )
        },
        {
            name: 'Agent ID',
            formatter: (_, row) => gridjs.html(
                `<a href="javascript:void(0);">${row.cells[0].data}</a>`
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
                            <span class="text-muted fs-13">${row.cells[4].data}</span>
                        </div>
                    </div>
                </a>`
            )
        },
        {
            name: 'Location',
            formatter: (_, row) => gridjs.html(
                `<span><i class="ri-map-pin-line text-muted"></i> ${row.cells[5].data}</span>`
            )
        },
        {
            name: 'Status',
            formatter: (_, row) => gridjs.html(
                `<span class="badge bg-${row.cells[3].data === 'Active' ? 'success' : row.cells[3].data === 'Inactive' ? 'danger' : 'warning'}-transparent">${row.cells[3].data}</span>`
            )
        },
        {
            name: 'Commission Rate',
            formatter: (_, row) => row.cells[8].data
        },
        {
            name: 'Specialization',
            formatter: (_, row) => row.cells[6].data
        },
        {
            name: 'Experience',
            formatter: (_, row) => row.cells[7].data
        },
        {
            name: 'Actions',
            formatter: (_, row) => gridjs.html(`
                <div class="d-flex gap-2">
                    <a href="tel:${row.cells[8].data}" class="btn btn-sm btn-success">Call</a>
                    <a href="sms:${row.cells[8].data}" class="btn btn-sm btn-primary">Message</a>
                </div>
            `)
        }
    ],
    data: agentsData,
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