<div class="space-y-8 p-6">
  <?php if (isset($blogs) && count($blogs) > 0): ?>
    <div class="bg-white shadow-md rounded-lg p-6">
      <!-- Table Header -->
      <div class="grid grid-cols-12 gap-4 mb-4">
        <div class="col-span-5 font-bold text-gray-800">Title</div>
        <div class="col-span-2 font-bold text-gray-800">Image</div>
        <div class="col-start-10 col-end-13 font-bold text-gray-800">Actions</div>
      </div>

      <!-- Table Rows -->
      <?php foreach ($blogs as $blog): ?>
        <div class="grid grid-cols-12 py-4 border-t border-gray-200 h-16 gap-x-6">
          <!-- Title Column -->
          <div class="col-span-5">
            <h4 class="text-lg font-semibold text-gray-600"><?= htmlspecialchars($blog->title) ?></h4>
            <!-- <p class="text-gray-600"><?= htmlspecialchars($blog->description) ?></p> -->
          </div>

          <!-- Image Column -->
          <div class="col-start-6 col-end-8 h-12">
            <img src="<?= htmlspecialchars($blog->image) ?>" alt="<?= htmlspecialchars($blog->title) ?>" class="w-full h-full rounded object-cover">
          </div>

          <!-- Actions Column -->
          <div class="col-start-10 col-end-13 space-x-6">
            <a href="/blogs/show/<?= $blog->id ?>" class="bg-blue-500 text-white py-2 px-2 py-2 rounded hover:bg-blue-600">View</a>
            <a href="/blogs/edit/<?= $blog->id ?>" class="bg-yellow-500 text-white py-2 px-2 rounded hover:bg-yellow-600">Edit</a>
            <form action="/blogs/delete/<?= $blog->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline-block">
              <button type="submit" class="bg-red-500 text-white px-2 py-2 rounded hover:bg-red-600">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-gray-600">No blogs found.</p>
  <?php endif; ?>
</div>
