<?php if (isset($_SESSION['blog_create_err'])): ?>
  <div class="w-96 bg-red-500 text-white p-4 ml-8 mt-8 rounded-lg">
    <?php echo $_SESSION['blog_create_err']['field_require']; ?>
    <?php unset($_SESSION['blog_create_err']) ?>
  </div>
<?php endif; ?>

<form action="/blogs/submit" method="POST" class="bg-white p-8 rounded-lg shadow-lg space-y-6 mt-2 max-w-6xl mx-auto">
  <input type="hidden" name="id">

  <!-- Title Field -->
  <div class="mb-6">
    <label for="title" class="block text-lg font-medium text-gray-700">Title:</label>
    <input type="text" id="title" name="title" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
  </div>

  <!-- Description Field -->
  <div class="mb-6">
    <label for="description" class="block text-lg font-medium text-gray-700">Description:</label>
    <textarea id="description" name="description" rows="6" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500"></textarea>
  </div>

  <!-- Tags Field -->
  <div class="mb-6">
    <label for="tags" class="block text-lg font-medium text-gray-700">Tags:</label>
    <input type="text" id="tags" name="tags" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
  </div>

  <!-- Category Field -->
  <div class="mb-6">
    <label for="category" class="block text-lg font-medium text-gray-700">Category:</label>
    <select id="category" name="category" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
      <?php foreach ($categories as $category): ?>
        <option value="<?= $category->category_title ?>"><?= $category->category_title ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Submit Button -->
  <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    Create
  </button>
</form>
