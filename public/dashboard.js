document.addEventListener('DOMContentLoaded', function() {
  const postsDropdownButton = document.getElementById('postsDropdownButton');
  const postsDropdown = document.getElementById('postsDropdown');
  const closeSidebarButton = document.getElementById('closeSidebarButton');
  const sidebar = document.querySelector('aside');

  // Toggle dropdown menu
  postsDropdownButton.addEventListener('click', function() {
    postsDropdown.classList.toggle('hidden');
  });

  // Prevent the dropdown from closing when clicking inside
  postsDropdown.addEventListener('click', function(event) {
    event.stopPropagation();
  });

  // Close the dropdown when clicking outside
  document.addEventListener('click', function(event) {
    if (!postsDropdownButton.contains(event.target)) {
      postsDropdown.classList.add('hidden');
    }
  });

  // Close the sidebar
  closeSidebarButton.addEventListener('click', function() {
    sidebar.classList.toggle('hidden');
  });
});
