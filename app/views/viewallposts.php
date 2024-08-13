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
    <a href="/viewallposts" class="text-3xl font-bold text-yellow-400">
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
  <div class="p-4 grid grid-cols-3 gap-6 px-12">
    <?php foreach ($blogs as $blog): ?>
      <div class="">
        <!-- Blog Card Start -->
        <div class="bg-blue-white rounded-lg shadow-md overflow-hidden">
          <div class="relative h-40 w-full max-w-full object-cover">
            <img src="<?= $blog->image ?>" alt="<?= $blog->title ?>" class="absolute top-0 left-0 w-full h-full object-cover">
          </div>
          <div class="p-4 flex justify-between items-start">
            <a href="/blogs/show/<?= $blog->id ?>" class="text-lg font-bold text-gray-700 hover:underline"><?= $blog->title ?></a>
            <div class="text-sm text-white text-right">
              <p class="text-gray-600">August 12, 2024</p>
              <p class="text-gray-600"><?= $blog->author->username ?></p>

            </div>
          </div>
        </div>
        <!-- Blog Card End -->
      </div>

    <?php endforeach; ?>
  </div>
</body>

</html>
