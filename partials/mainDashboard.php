    <!-- load dashboard homepage card -->
    <?php if ($_SERVER['REQUEST_URI'] === "/dashboard"): ?>
      <div class="container mx-auto p-8">
        <!-- Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- View All Posts Card -->
          <a href="/blogs" class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition-all transform hover:scale-105">
            <h2 class="text-2xl font-semibold mb-2">View All Posts</h2>
            <p class="text-lg mt-6">See a list of all your blog posts.</p>
          </a>

          <!-- Create New Blog Post Card -->
          <a href="/blogs/create" class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition-all transform hover:scale-105">
            <h2 class="text-2xl font-semibold mb-2">Create New Blog Post</h2>
            <p class="text-lg mt-6">Write and publish a new blog post.</p>
          </a>

          <!-- View All Blog Posts as User Card -->
          <a href="/viewallposts" class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition-all transform hover:scale-105">
            <h2 class="text-2xl font-semibold mb-2">View All Blog Posts as User</h2>
            <p class="text-lg mt-6">Browse blog posts as a regular user.</p>
          </a>

          <!-- View All Categories Card -->
          <a href="/category" class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition-all transform hover:scale-105">
            <h2 class="text-2xl font-semibold mb-2">View All The Categories</h2>
            <p class="text-lg mt-6">Browse all the categories and manage them.</p>
          </a>

          <!-- View All Categories Card -->
          <a href="/category/create" class="bg-green-500 text-white p-6 rounded-lg shadow-lg hover:bg-green-600 transition-all transform hover:scale-105">
            <h2 class="text-2xl font-semibold mb-2">Create a new category</h2>
            <p class="text-lg mt-6">Create and manage categories</p>
          </a>
        </div>
      </div>
    <?php endif ?>
