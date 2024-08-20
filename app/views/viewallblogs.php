<?php loadPartials("header") ?>
<!-- Navbar -->

<?php loadPartials("blogNav", ['isAdmin' => $isAdmin, 'username' => $username, 'isLoggedIn' => $isLoggedIn, 'categories' => $categories, 'sortBy' => $sortBy]); ?>

<!-- Blog Posts -->
<div class="grid grid-cols-3 gap-6 px-16 p-16">
  <?php if (count($blogs) > 0): ?>
    <?php foreach ($blogs as $blog): ?>
      <div class="">
        <!-- Blog Card Start -->
        <div class="bg-blue-white rounded-lg shadow-md overflow-hidden">
          <?php $cover_image = $blog->image; ?>
          <?php if (strlen($cover_image) > 0): ?>
            <div class="relative h-40 w-full max-w-full object-cover">
              <img class="absolute top-0 left-0 w-full h-full object-cover" src="<?= loadImagePath("cover_images/") . $blog->image ?>" alt="<?= $blog->title ?>">
            </div>
          <?php else: ?>
            <div class="relative h-40 w-full max-w-full object-cover">
              <img class="absolute top-0 left-0 w-full h-full object-cover" src="<?= loadImagePath("cover_images/cover.jpg") ?>" alt="<?= $blog->title ?>">
            </div>
          <?php endif ?>

          <div class="p-4 flex justify-between items-start">
            <a href="/blogs/show/<?= $blog->id ?>" class="text-lg font-bold text-gray-700 hover:underline max-w-60"><?= $blog->title ?></a>
            <div class="text-sm text-white text-right">
              <p class="text-gray-600"><?= simpleFormatDate($blog->created_at) ?></p>
              <p class="text-gray-600"><?= $blog->username ?></p>
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
        <a href="/viewallblogs" class="mt-6 inline-block bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-600 transition">
          Go Back to Home
        </a>
      </div>
    </div>
  <?php endif ?>
</div>
<?php loadPartials("footer") ?>
