<nav class="bg-blue-600 p-4 text-white grid grid-cols-12 items-center">
  <!-- Left Side -->
  <div class="col-span-4 flex items-center space-x-4">
    <!-- Logo Link -->
    <a href="/viewallblogs" class="text-3xl font-bold text-yellow-400">
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
        <?php foreach ($categories as $category): ?>
          <li><a class="rounded-t bg-blue-100 hover:bg-blue-200 py-2 px-4 block whitespace-no-wrap" href="#"><?= $category->title ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>

    <!-- Sort Menu -->
    <?php $sortTile = isset($sortBy) && $sortBy === "asc" ? "Ascending" : "Descending" ?>
    <div class="relative">
      <!-- Sort By Button -->
      <button id="dropdownButton" class="inline-flex justify-center px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
        <?= $sortTile ?>
        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v10.59l2.3-2.3a1 1 0 011.4 1.42l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.42L9 14.6V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
      </button>

      <div id="dropdownMenu" class="origin-top-left absolute left-0 -mt-0 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
        <!-- Ascending Sort Button -->
        <a href="/blogs/sort/asc" name="sort" class="w-full text-left px-4 py-2 flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-gray-700 rounded transition">
          <span>Ascending</span>
        </a>

        <!-- Descending Sort Button -->
        <a href="/blogs/sort/desc" name="sort" class="w-full text-left px-4 py-2 flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-gray-700 rounded transition">
          <span>Descending</span>
        </a>

      </div>
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

    <div class="flex items-center space-x-4">
      <span class="text-xl"><?= $username ?>!</span>
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
    <!-- register button -->
    <?php if (!isset($_SESSION['user'])): ?>
      <div class="flex items-center space-x-2">
        <a href="/register/load" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
          Register
        </a>
      </div>
    <?php endif; ?>
  </div>
</nav>
