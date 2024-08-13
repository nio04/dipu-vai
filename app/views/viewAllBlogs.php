<div class="space-y-8 p-6">
  <?php if (isset($blogs)) : ?>
    <?php foreach ($blogs as $blog): ?>
      <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center">

        <!-- Left Side: Title and Description -->
        <div class="w-9/12">
          <h4 class="text-xl font-semibold mb-2 text-gray-800"><?= $blog->title ?></h4>
          <p class="text-gray-600 mb-4"><?= $blog->description ?></p>
        </div>

        <!-- Right Side: Action Buttons -->
        <div class="space-x-4">
          <a href="/blogs/show/<?= $blog->id ?>" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">View</a>
          <a href="/blogs/edit/<?= $blog->id ?>" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
          <form action="/blogs/delete/<?= $blog->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline-block">
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Delete</button>
          </form>
        </div>

      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
