const postsDropdownButton = document.getElementById('postsDropdownButton');
const postsDropdown = document.getElementById('postsDropdown');
const closeSidebarButton = document.getElementById('closeSidebarButton');
const openSidebarButton = document.getElementById('openSidebarButton');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
const dropdownButton = document.getElementById('dropdownButton');
const dropdownMenu = document.getElementById('dropdownMenu');

// Toggle dropdown menu
if (postsDropdownButton) {
  postsDropdownButton.addEventListener('click', function () {
    postsDropdown.classList.toggle('hidden');
  });
}

// Open the sidebar
if (openSidebarButton) { 
  openSidebarButton.addEventListener('click', function() {
    sidebar.classList.remove('-translate-x-64');
    openSidebarButton.classList.add('hidden');
  });
}

// Close the sidebar
if (closeSidebarButton) { 
  closeSidebarButton.addEventListener('click', function() {
    sidebar.classList.add('-translate-x-64');
    mainContent.classList.remove('ml-64');
    openSidebarButton.classList.remove('hidden');
  });
}


// Show the dropdown menu on hover
if (document.querySelector('.dropdown-menu')) { 
  document.querySelector('.dropdown-menu').parentNode.addEventListener('mouseenter', function() {
    this.querySelector('.dropdown-menu').classList.remove('hidden');
  });
}

// Hide the dropdown menu when not hovering
if (document.querySelector('.dropdown-menu')) {
 document.querySelector('.dropdown-menu').parentNode.addEventListener('mouseleave', function() {
    this.querySelector('.dropdown-menu').classList.add('hidden');
  });
}

// Show dropdown on mouse enter
if (dropdownButton) {
 dropdownButton.addEventListener('mouseenter', function() {
    dropdownMenu.classList.remove('hidden');
    dropdownButton.setAttribute('aria-expanded', 'true');
  });
}

// Hide dropdown on mouse leave
if (dropdownButton) {
 dropdownButton.addEventListener('mouseleave', function() {
    dropdownMenu.classList.add('hidden');
    dropdownButton.setAttribute('aria-expanded', 'false');
  });
}

// Ensure dropdown hides when mouse leaves the dropdown menu
if (dropdownMenu) { 
  dropdownMenu.addEventListener('mouseleave', function() {
    dropdownMenu.classList.add('hidden');
    dropdownButton.setAttribute('aria-expanded', 'false');
  });
}

// Keep dropdown visible when hovering over it
if (dropdownMenu) {
 dropdownMenu.addEventListener('mouseenter', function() {
    dropdownMenu.classList.remove('hidden');
    dropdownButton.setAttribute('aria-expanded', 'true');
  });
}
  