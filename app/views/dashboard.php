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
          <a href="/blogs" class="bg-white inline-block py-2 px-4 text-blue-600 border <?php echo ($_SERVER['REQUEST_URI'] === "/blogs" ? "border-blue-600" : "border border-gray-300"); ?> rounded-t hover:bg-blue-50">
            View All Posts
          </a>
        </li>
        <li class="mr-1">
          <a href="/blogs/create" class="bg-white inline-block py-2 px-4 text-gray-600 border <?php echo ($_SERVER['REQUEST_URI'] === "/blogs/create" ? "border-blue-600" : "border border-gray-300"); ?> rounded-t hover:bg-gray-50">
            Create Post
          </a>
        </li>

      </ul>
    </div>

    <!-- Tab Content -->
    <div class="space-y-8 p-6">
      <?php if (isset($blogs)) : ?>
        <?php foreach ($blogs as $blog): ?>
          <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-semibold mb-2 text-gray-800"><?= $blog->title ?></h4>
            <p class="text-gray-600 mb-4"><?= $blog->description ?></p>
            <a href="/blogs/show/<?= $blog->id ?>" class="text-blue-500 hover:text-blue-700 font-medium">View Full Post</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['blog_create_err'])): ?>
      <div class="bg-red-500 text-white p-4 mb-4 rounded">
        <?php echo $_SESSION['blog_create_err']['field_require']; ?>
      </div>
    <?php endif; ?>

    <?php if ($_SERVER['REQUEST_URI'] === '/blogs/create'): ?>
      <form action="/blogs/create" method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-4">
        <div class="mb-4">
          <label for="title" class="block text-gray-700">Title:</label>
          <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700">Description:</label>
          <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>
        <div class="mb-4">
          <label for="tags" class="block text-gray-700">Tags:</label>
          <input type="text" id="tags" name="tags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., tech, programming">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Submit</button>
      </form>
    <?php endif; ?>

  </main>

</body>

</html>
