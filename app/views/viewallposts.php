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
  $isAdmin = isset($_SESSION['settings']['admin']) && $_SESSION['settings']['admin'];
  ?>

  <nav class="bg-blue-600 p-4 text-white rounded-lg grid grid-cols-12 items-center">
    <!-- Left Side -->
    <div class="col-span-4 flex items-center space-x-4">
      <!-- Logo Link -->
      <a href="/viewallposts" class="text-3xl font-bold text-yellow-400">
        Bloggies
      </a>

      <!-- Dropdown Menu -->
      <div class="relative">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
          <span>Menu</span>
          <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M0 0h20v20H0z" fill="none" />
            <path d="M7 10l5 5 5-5H7z" />
          </svg>
        </button>
        <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 pb-1 bg-white rounded shadow-lg w-48 z-10 transition-all">
          <li><a class="rounded-t bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">General</a></li>
          <li><a class="rounded-t bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Howto</a></li>
          <li><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Guide</a></li>
          <li><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">DIY</a></li>
          <li><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Novel</a></li>
          <li><a class="bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Picture Story</a></li>
          <li><a class="rounded-b bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#">Analysis Report</a></li>
        </ul>
      </div>

      <!-- Sort Menu -->
      <div class="relative">
        <button id="dropdownButton" class="inline-flex justify-center px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
          Sort By
          <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v10.59l2.3-2.3a1 1 0 011.4 1.42l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.42L9 14.6V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
        </button>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Sort Form</title>
          <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3.2/dist/tailwind.min.css" rel="stylesheet">
        </head>

        <form action="/blogs/sort" method="POST" id="dropdownMenu" class="origin-top-left absolute left-0 -mt-0 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
          <!-- Ascending Sort Button -->
          <button type="submit" name="sort" value="asc" class="w-full text-left px-4 py-2 flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-gray-700 rounded transition">
            <span>Ascending</span>
          </button>

          <!-- Descending Sort Button -->
          <button type="submit" name="sort" value="desc" class="w-full text-left px-4 py-2 flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-gray-700 rounded transition">
            <span>Descending</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Right Side -->
    <div class="col-span-8 flex items-center justify-end space-x-4">
      <!-- Go Back to Dashboard Button -->
      <div class="mr-12">
        <?php if ($isAdmin): ?>
          <a href="/dashboard" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Back to Dashboard
          </a>
        <?php endif; ?>
      </div>

      <!-- Search Container -->
      <div class="flex items-center space-x-2">
        <form action="/blogs/search" method="POST" class="flex items-center space-x-2">
          <input type="search" name="search" id="search" placeholder="Enter your query" class="bg-blue-500 text-white placeholder-white px-6 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 transition" />
          <input type="submit" value="Search" class="bg-blue-500 text-yellow-400 font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-600 hover:text-yellow-100 transition" />
        </form>
      </div>

      <!-- Welcome Message and Buttons -->
      <div class="flex items-center space-x-4">
        <span class="text-xl"><?php echo $username; ?>!</span>
        <?php if ($isLoggedIn): ?>
          <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
              Log out
            </button>
          </form>
        <?php else: ?>
          <a href="/login" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
            Log in
          </a>
        <?php endif; ?>
      </div>
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
              <p class="text-gray-600"><?= simpleFormatDate($blog->created_at) ?></p>
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

    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Show dropdown on mouse enter
    dropdownButton.addEventListener('mouseenter', function() {
      dropdownMenu.classList.remove('hidden');
      dropdownButton.setAttribute('aria-expanded', 'true');
    });

    // Hide dropdown on mouse leave
    dropdownButton.addEventListener('mouseleave', function() {
      dropdownMenu.classList.add('hidden');
      dropdownButton.setAttribute('aria-expanded', 'false');
    });

    // Ensure dropdown hides when mouse leaves the dropdown menu
    dropdownMenu.addEventListener('mouseleave', function() {
      dropdownMenu.classList.add('hidden');
      dropdownButton.setAttribute('aria-expanded', 'false');
    });

    // Keep dropdown visible when hovering over it
    dropdownMenu.addEventListener('mouseenter', function() {
      dropdownMenu.classList.remove('hidden');
      dropdownButton.setAttribute('aria-expanded', 'true');
    });
  </script>
</body>

</html>
