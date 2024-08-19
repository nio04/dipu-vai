<!-- admin view: all blog lists -->
<div class="space-y-8 p-6">
  <?php if (isset($blogs) && count($blogs) > 0): ?>
    <div class="bg-white shadow-md rounded-lg p-6">

      <!-- Table Header -->
      <div class="grid grid-cols-12 justify-items-start gap-4 mb-4">
        <div class="col-start-1 col-end-2 font-bold text-gray-800">Title</div>
        <div class="col-start-6 col-end-8 justify-self-center  font-bold text-gray-800">Image</div>
        <div class="col-start-10 col-end-13 font-bold text-gray-800">Actions</div>
      </div>

      <!-- Table Rows -->
      <?php foreach ($blogs as $blog): ?>
        <div class="grid grid-cols-12 border-t border-gray-200 h-14 gap-x-4 items-center">
          <!-- Title Column -->
          <div class="col-span-5 flex items-center">
            <h4 class="text-lg font-semibold text-gray-600"><?= htmlspecialchars($blog->title) ?></h4>
          </div>

          <!-- Image Column -->
          <?php $cover_image = $blog->image; ?>
          <?php if (strlen($cover_image) > 0): ?>
            <div class="col-start-6 col-end-8 h-12 flex items-center">
              <img class="w-full h-full rounded object-cover" src="<?= loadImagePath("cover_images/") . $blog->image ?>" alt="<?= $blog->title ?>">
            </div>
          <?php else: ?>
            <div class="col-start-6 col-end-8 h-12 flex items-center">
              <img class="w-full h-full rounded object-cover" src="<?= loadImagePath("cover_images/cover.jpg") ?>" alt="<?= $blog->title ?>">
            </div>
          <?php endif ?>


          <!-- Actions Column -->
          <div class="col-start-10 col-end-13 flex items-center justify-start space-x-2">
            <a href="/blogs/show/<?= $blog->id ?>" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600">View</a>
            <a href="/blogs/edit/<?= $blog->id ?>" class="bg-yellow-500 text-white py-1 px-2 rounded hover:bg-yellow-600">Edit</a>
            <form action="/blogs/delete/<?= $blog->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline-block">
              <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-600">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  <?php else: ?>
    <p class="text-gray-600">No blogs found.</p>
  <?php endif; ?>
</div>
