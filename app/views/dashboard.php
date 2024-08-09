<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include TailwindCSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-blue-600 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
      <a href="/" class="text-2xl font-bold">MyApp</a>
      <a href="/logout" class="bg-red-500 px-4 py-2 rounded">Logout</a>
    </div>
  </nav>

  <!-- Main content -->
  <main class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-4">Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h1>

    <!-- Tabs -->
    <div class="mb-4">
      <ul class="flex border-b">
        <li class="-mb-px mr-1">
          <a href="?tab=all-posts" class="bg-white inline-block py-2 px-4 text-blue-600 border border-blue-600 rounded-t hover:bg-blue-50">View All Posts</a>
        </li>
        <li class="mr-1">
          <a href="?tab=create-post" class="bg-white inline-block py-2 px-4 text-gray-600 border border-gray-300 rounded-t hover:bg-gray-50">Create Post</a>
        </li>
      </ul>
    </div>

    <!-- Tab Content -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
      <?php if (isset($_GET['tab']) && $_GET['tab'] === 'create-post'): ?>
        <h2 class="text-xl font-semibold mb-4">Create a New Post</h2>
        <!-- Form for creating a post -->
        <form action="/create-post" method="POST">
          <div class="mb-4">
            <label for="title" class="block text-gray-700">Title:</label>
            <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
          </div>
          <div class="mb-4">
            <label for="content" class="block text-gray-700">Content:</label>
            <textarea id="content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
          </div>
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit</button>
        </form>
      <?php else: ?>
        <h2 class="text-xl font-semibold mb-4">All Posts</h2>
        <!-- Placeholder for displaying posts -->
        <p>No posts available.</p>
      <?php endif; ?>
    </div>
  </main>

</body>

</html>
