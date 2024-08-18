<!-- Button to open the sidebar -->
<button id="openSidebarButton" class="fixed top-20 left-4 bg-green-500 text-white text-xl font-semibold p-4 rounded-full shadow-lg hover:bg-green-600 focus:outline-none z-30">
  Open Sidebar
</button>

<!-- Sidebar -->
<aside id="sidebar" class="w-1/5 bg-white shadow-lg rounded-lg fixed top-18 left-0 h-screen z-50 transition-transform transform">
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
        <ul id="postsDropdown" class="mt-2 hidden bg-gray-200 rounded-lg space-y-2">
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

      <!-- Category link -->
      <li>
        <a href="/category" class="block text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 underline underline-offset-8">
          Categories
        </a>
      </li>
      <!-- Another link -->
      <li>
        <a href="/viewallposts" class="block text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 underline underline-offset-8">
          View All Posts as user
        </a>
      </li>
    </ul>
  </div>
</aside>
