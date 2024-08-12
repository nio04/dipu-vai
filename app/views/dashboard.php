<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include TailwindCSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">

  <!-- Sidebar -->
  <aside id="sidebar" class="w-64 bg-white shadow-lg rounded-lg sticky top-0 h-screen z-10 relative transition-transform transform -translate-x-64">
    <button id="closeSidebarButton" class="absolute top-4 right-4 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 focus:outline-none w-8 h-8 flex items-center justify-center">
      <span class="text-xl">×</span>
    </button>
    <div class="p-6">
      <h2 class="text-xl font-semibold mb-4">Navigation</h2>
      <ul class="space-y-4">
        <li>
          <button id="postsDropdownButton" class="w-full text-left bg-gray-200 px-4 py-2 rounded-md focus:outline-none hover:bg-gray-300">
            Posts
            <svg class="w-5 h-5 inline-block float-right" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <ul id="postsDropdown" class="mt-2 hidden bg-gray-50 rounded-lg space-y-2">
            <li>
              <a href="/blogs" class="block text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                View All Posts
              </a>
            </li>
            <li>
              <a href="/blogs/create" class="block text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200">
                Create Post
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>

  <!-- Button to open the sidebar -->
  <button id="openSidebarButton" class="fixed top-4 left-4 bg-green-500 text-white text-xl font-semibold p-4 rounded-full shadow-lg hover:bg-green-600 focus:outline-none">
    Open Sidebar
  </button>

  <!-- Main content -->
  <main id="mainContent" class="flex-1 p-6 transition-margin duration-300 ml-0">
    <nav class="bg-blue-600 p-4 text-white flex items-center justify-between rounded-lg">
      <h1 class="text-2xl font-semibold">Welcome to your Dashboard!</h1>
      <div class="flex items-center space-x-4">
        <span class="text-lg font-bold"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
        <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
            Log out
          </button>
        </form>
      </div>
    </nav>

    <?php if (isset($_SESSION['blog_create_err'])): ?>
      <div class="bg-red-500 text-white p-4 mb-4 rounded-lg">
        <?php echo $_SESSION['blog_create_err']['field_require']; ?>
      </div>
    <?php endif; ?>

    <!-- load view all posts -->
    <?php if ($_SERVER['REQUEST_URI'] === '/blogs'): ?>
      <?php loadView('viewAllBlogs', ['blogs' => $blogs]) ?>
    <?php endif; ?>

    <!-- load create post -->
    <?php if ($_SERVER['REQUEST_URI'] === '/blogs/create'): ?>
      <?php loadView('createBlog') ?>
    <?php endif; ?>


  </main>

  <!-- JavaScript code -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const postsDropdownButton = document.getElementById('postsDropdownButton');
      const postsDropdown = document.getElementById('postsDropdown');
      const closeSidebarButton = document.getElementById('closeSidebarButton');
      const openSidebarButton = document.getElementById('openSidebarButton');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');

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

      // Open the sidebar
      openSidebarButton.addEventListener('click', function() {
        sidebar.classList.remove('-translate-x-64');
        openSidebarButton.classList.add('hidden');
      });

      // Close the sidebar
      closeSidebarButton.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-64');
        mainContent.classList.remove('ml-64');
        openSidebarButton.classList.remove('hidden');
      });
    });
  </script>

</body>

</html>
