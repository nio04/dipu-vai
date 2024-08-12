<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Include TailwindCSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex-col my-6 px-8">

  <!-- Navbar -->
  <?php
  // Check if a user is logged in from the session
  $isLoggedIn = isset($_SESSION['user']['username']);
  $username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : 'Guest';
  ?>

  <?php
  // Check if a user is logged in from the session
  $isLoggedIn = isset($_SESSION['user']['username']);
  $username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : 'Guest';
  $isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'];
  ?>

  <!-- Navbar -->
  <nav class="bg-blue-600 p-4 text-white flex items-center justify-between rounded-lg">
    <!-- Logo Link -->
    <a href="/blogs" class="text-3xl font-bold text-yellow-400">
      Bloggies
    </a>
    <!-- Welcome Message and Buttons -->
    <div class="flex items-center space-x-4">
      <?php if ($isAdmin): ?>
        <!-- Go Back to Dashboard Button -->
        <a href="/dashboard" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mr-12">
          Go Back to Dashboard
        </a>
      <?php endif; ?>
      <span class="text-xl">Welcome, <?php echo $username; ?>!</span>
      <?php if ($isLoggedIn): ?>
        <!-- Logout Button -->
        <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
            Log out
          </button>
        </form>
      <?php else: ?>
        <!-- Login Button -->
        <a href="/login" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
          Log in
        </a>
      <?php endif; ?>
    </div>
  </nav>


  <!-- Blog Posts -->
  <div class="p-4">
    <?php foreach ($blogs as $blog): ?>
      <div class="bg-white p-4 mb-4 rounded-lg shadow-md">
        <!-- Post Title (Clickable Link) -->
        <a href="/blogs/show/<?php echo $blog->id ?>" class="text-xl font-bold text-blue-600 hover:underline">
          <?php echo htmlspecialchars($blog->title) ?>
        </a>
        <!-- Post Description -->
        <p class="mt-2 text-gray-700">
          <?php echo htmlspecialchars($blog->description); ?>
        </p>
        <!-- View Full Post Link -->
        <a href="/blogs/show/<?php echo $blog->id; ?>" class="mt-2 text-blue-500 hover:underline block">
          View Full Post
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</body>

</html>
