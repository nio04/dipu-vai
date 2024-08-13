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

  <nav class="bg-blue-600 p-4 text-white flex items-center justify-between rounded-lg">
    <!-- Logo Link -->
    <a href="/viewallposts" class="text-3xl font-bold text-yellow-400">
      Bloggies
    </a>

    <!-- Dropdown Menu -->
    <div class="relative mr-auto ml-8">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
        <span>Menu</span>
        <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M0 0h20v20H0z" fill="none" />
          <path d="M7 10l5 5 5-5H7z" />
        </svg>
      </button>
      <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 bg-white rounded shadow-lg w-48 z-10 transition-all">
        <li class=""><a class="rounded-t bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Howto</a></li>
        <li class=""><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Guide</a></li>
        <li class=""><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">DIY</a></li>
        <li class=""><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Novel</a></li>
        <li class=""><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Picture Story</a></li>
        <li class=""><a class="rounded-b bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Analysis Report</a></li>
      </ul>
    </div>

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

  <script>
    // Show the dropdown menu on hover
    document.querySelector('.dropdown-menu').parentNode.addEventListener('mouseenter', function() {
      this.querySelector('.dropdown-menu').classList.remove('hidden');
    });

    // Hide the dropdown menu when not hovering
    document.querySelector('.dropdown-menu').parentNode.addEventListener('mouseleave', function() {
      this.querySelector('.dropdown-menu').classList.add('hidden');
    });
  </script>
</body>

</html>
