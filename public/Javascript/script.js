document.getElementById('open_btn').addEventListener('click', function () {
  const sidebar = document.getElementById('sidebar');
  const dropdowns = document.querySelectorAll('.dropdown');
  const arrowIcon = document.getElementById('arrow-icon');

  // Toggle sidebar visibility
  sidebar.classList.toggle('open-sidebar');

  // Close all dropdowns
  dropdowns.forEach(dropdown => {
      dropdown.style.display = 'none';
  });

  // Reset arrow icon if sidebar is closing
  if (!sidebar.classList.contains('open-sidebar')) {
      arrowIcon.style.transform = 'rotate(0deg)';
  }
});

// --------------------------------------------

const sideItems = document.querySelectorAll('.side-item');

sideItems.forEach(item => {
  item.addEventListener('click', () => {
      // Remove 'active' class from all side items
      sideItems.forEach(sideItem => {
          sideItem.classList.remove('active');
      });

      // Add 'active' class to the clicked item
      item.classList.add('active');
  });
});

// ----------------------------------------------

document.getElementById('menu-toggle').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the default action of the link
  const dropdown = this.nextElementSibling.querySelector('.dropdown');
  const arrowIcon = document.getElementById('arrow-icon');

  // Toggle dropdown visibility
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

  // Rotate the arrow icon
  if (dropdown.style.display === 'block') {
      arrowIcon.style.transform = 'rotate(180deg)';
  } else {
      arrowIcon.style.transform = 'rotate(0deg)';
  }
});


document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('section');
  const navLinks = document.querySelectorAll('#side_items a');

  const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.6 // Adjusts when the section is considered in view
  };

  const observerCallback = (entries) => {
      entries.forEach(entry => {
          const id = entry.target.getAttribute('id');
          const navLink = document.querySelector(`#side_items a[href="#${id}"]`);

          if (entry.isIntersecting) {
              navLink.classList.add('active');
          } else {
              navLink.classList.remove('active');
          }
      });
  };

  const observer = new IntersectionObserver(observerCallback, observerOptions);

  sections.forEach(section => {
      observer.observe(section);
  });
});




