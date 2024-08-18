<?php if (isset($_SESSION['blog_create_err'])): ?>
  <div class="w-96 bg-red-500 text-white p-4 ml-8 mt-8 rounded-lg">
    <?php echo $_SESSION['blog_create_err']['field_require']; ?>
    <?php unset($_SESSION['blog_create_err']) ?>
  </div>
<?php endif; ?>

<!-- Form -->
<form action="/blogs/submit" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg space-y-6 max-w-6xl mx-auto">
  <input type="hidden" name="id">
  <h1 class="text-2xl font-bold text-gray-600 text-left mb-2">Create a New Blog</h1>

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
        <option value="<?= $category->id ?>"><?= $category->title ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- File Upload Field -->
  <div class="mb-6">
    <label for="cover_image" class="block text-lg font-medium text-gray-700">Cover Image:</label>
    <div class="mt-2 flex items-center">
      <input type="file" id="cover_image" name="cover_image" class="block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:ring-blue-500 focus:border-blue-500">
    </div>
  </div>

  <!-- Submit Button -->
  <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    Create
  </button>
</form>
