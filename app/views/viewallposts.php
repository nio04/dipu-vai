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

<?php loadPartials("blogNav", ['isAdmin' => $isAdmin, 'username' => $username, 'isLoggedIn' => $isLoggedIn, '']); ?>

<!-- Blog Posts -->
<div class="grid grid-cols-3 gap-6 px-16 p-16">
  <?php foreach ($blogs as $blog): ?>
    <div class="">
      <!-- Blog Card Start -->
      <div class="bg-blue-white rounded-lg shadow-md overflow-hidden">
        <div class="relative h-40 w-full max-w-full object-cover">
          <img src="<?= loadImagePath("cover_images/") . $blog->image ?>" alt="<?= $blog->title ?>" class="absolute top-0 left-0 w-full h-full object-cover">
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
</div>
<?php loadPartials("footer") ?>
