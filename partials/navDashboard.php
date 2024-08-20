<nav class="bg-blue-600 p-4 text-white flex items-center sticky top-0 left-0 z-50">
  <!-- Logo Link -->
  <a href="/dashboard" class="text-3xl font-bold text-yellow-400 mr-6">
    Bloggies
  </a>
  <!-- Dashboard Title -->
  <h1 class="text-2xl font-semibold mr-auto">Welcome to your Dashboard!</h1>
  <div class="flex items-center space-x-4">
    <!-- create new post -->
    <?php
    // Check if the user is logged in and the URI is '/blogs'
    if (isset($showCreatePostBtn)) {
      echo '<a href="/blogs/create" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded mr-12">Create A New Post</a>';
    }
    ?>

    <!-- create new category -->
    <?php
    if (isset($showCategoryBtn)) {
      echo '<a href="/category/create" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded mr-12">Create New Category</a>';
    }
    ?>

    <span class="text-lg font-bold"><?php echo htmlspecialchars($showUserName); ?></span>
    <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
      <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
        Log out
      </button>
    </form>
  </div>
</nav>
