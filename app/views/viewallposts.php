<?php loadPartials("header") ?>
<!-- Navbar -->
<?php
// Check if a user is logged in from the session
$isLoggedIn = isset($_SESSION['user']['username']);
$username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : 'Guest';

// Check if a user is logged in from the session
$isLoggedIn = isset($_SESSION['user']['username']);
$username = $isLoggedIn ? htmlspecialchars($_SESSION['user']['username']) : 'Guest';
$isAdmin = isset($_SESSION['settings']['admin']) && $_SESSION['settings']['admin'];
?>

<?php loadPartials("blogNav", ['isAdmin' => $isAdmin, 'username' => $username, 'isLoggedIn' => $isLoggedIn, '', 'categories' => $categories]); ?>

<!-- Blog Posts -->
<div class="grid grid-cols-3 gap-6 px-16 p-16">
  <?php if (count($blogs) > 0): ?>
    <?php foreach ($blogs as $blog): ?>
      <div class="">
        <!-- Blog Card Start -->
        <div class="bg-blue-white rounded-lg shadow-md overflow-hidden">
          <div class="relative h-40 w-full max-w-full object-cover">
            <img src="<?= loadImagePath("cover_images/") . $blog->image ?>" alt="<?= $blog->image ?>" class="absolute top-0 left-0 w-full h-full object-cover">
          </div>
          <div class="p-4 flex justify-between items-start">
            <a href="/blogs/show/<?= $blog->id ?>" class="text-lg font-bold text-gray-700 hover:underline"><?= $blog->title ?></a>
            <div class="text-sm text-white text-right">
              <p class="text-gray-600"><?= simpleFormatDate($blog->created_at) ?></p>
              <p class="text-gray-600"><?= $blog->author->username ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="flex items-start justify-center h-screen w-screen">
      <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-700 mb-4">No Results Found</h1>
        <p class="text-lg text-gray-500">
          We couldn't find any blog posts that match your search.
        </p>
        <a href="/viewallposts" class="mt-6 inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
          Go Back to Home
        </a>
      </div>
    </div>
  <?php endif ?>
</div>
<?php loadPartials("footer") ?>
