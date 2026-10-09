/* For Categoty Search Dropdown */
document.addEventListener('DOMContentLoaded', function () {
  const categoriesButton = document.querySelector('.categories-btn');
  const dropdownMenu = document.querySelector('.hover-dropdown');
  const dropdownItems = document.querySelectorAll('.categories-item');

  // Show dropdown on hover
  categoriesButton.addEventListener('mouseenter', function () {
      dropdownMenu.style.display = 'block';
      dropdownMenu.style.opacity = '1';
  });

  // Ensure dropdown stays visible while hovering over it
  dropdownMenu.addEventListener('mouseenter', function () {
      dropdownMenu.style.display = 'block';
      dropdownMenu.style.opacity = '1';
  });

  // Hide dropdown when mouse leaves both the button and menu
  categoriesButton.addEventListener('mouseleave', function () {
      setTimeout(function () {
          if (!dropdownMenu.matches(':hover')) {
              dropdownMenu.style.display = 'none';
              dropdownMenu.style.opacity = '0';
          }
      }, 200);
  });

  dropdownMenu.addEventListener('mouseleave', function () {
      dropdownMenu.style.display = 'none';
      dropdownMenu.style.opacity = '0';
  });

  // Add click event to each dropdown item
  dropdownItems.forEach(function (item) {
      item.addEventListener('click', function () {
          // Remove the active class from all dropdown items
          dropdownItems.forEach(function (i) {
              i.classList.remove('active');
          });

          // Add active class to the selected item
          this.classList.add('active');

          // Get the category name from the data-category attribute
          const selectedCategory = this.getAttribute('data-category');

          // Update the button text with the selected category
          categoriesButton.textContent = selectedCategory;

          // Hide dropdown after selection
          dropdownMenu.style.display = 'none';
          dropdownMenu.style.opacity = '0';
      });
  });
});
/* For Categoty Search Dropdown */