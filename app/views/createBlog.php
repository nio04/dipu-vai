<?php if (isset($_SESSION['blog_create_err'])): ?>
  <div class=" w-96 bg-red-500 text-white p-4 ml-8 mt-8 rounded-lg">
    <?php echo $_SESSION['blog_create_err']['field_require']; ?>
    <!-- after showing error message, then unset it to not load the error message again when viewing the view -->
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

  <!-- Category Section -->
  <div class="mb-6">
    <label for="category" class="block text-lg font-medium text-gray-700 mb-2">Category:</label>
    <div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
      <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
        <div class="flex items-center">
          <input type="checkbox" id="howto" name="category[]" value="howto" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="howto" class="ml-2 text-gray-700 cursor-pointer">Howto</label>
        </div>
        <div class="flex items-center">
          <input type="checkbox" id="guide" name="category[]" value="guide" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="guide" class="ml-2 text-gray-700 cursor-pointer">Guide</label>
        </div>
        <div class="flex items-center">
          <input type="checkbox" id="diy" name="category[]" value="DIY" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="diy" class="ml-2 text-gray-700 cursor-pointer">DIY</label>
        </div>
        <div class="flex items-center">
          <input type="checkbox" id="novel" name="category[]" value="novel" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="novel" class="ml-2 text-gray-700 cursor-pointer">Novel</label>
        </div>
        <div class="flex items-center">
          <input type="checkbox" id="picture_story" name="category[]" value="picture_story" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="picture_story" class="ml-2 text-gray-700 cursor-pointer">Picture Story</label>
        </div>
        <div class="flex items-center">
          <input type="checkbox" id="analysis_report" name="category[]" value="analysis_report" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
          <label for="analysis_report" class="ml-2 text-gray-700 cursor-pointer">Analysis Report</label>
        </div>
      </div>
    </div>
  </div>



  <!-- Submit Button -->
  <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    Create
  </button>
</form>
