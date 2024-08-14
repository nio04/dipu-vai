<div class="space-y-8 p-6">
  <h1 class="text-2xl font-semibold ">Category: <?= $categoryId[0] ?></h1>

  <?php if (count($categoryBlogs) > 0): ?>
    <?php foreach ($categoryBlogs as $blog): ?>
      <div class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center">
        <!-- Left Side: Title and Description -->
        <div class="w-9/12">
          <h4 class="text-xl font-semibold mb-2 text-gray-800"><?= htmlspecialchars($blog->title) ?></h4>
          <p class="text-gray-600 mb-4"><?= htmlspecialchars($blog->description) ?></p>
        </div>

        <!-- Right Side: Action Buttons -->
        <div class="space-x-4">
          <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">View</a>
          <a href="#" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
          <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');" class="inline-block">
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Delete</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-gray-400 text-4xl mt-16">No blogs found for this category: <?= $categoryId[0] ?></p>
  <?php endif; ?>

</div>
