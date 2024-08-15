<?php $errors = $_SESSION['errors'] ?? [] ?>

<?php foreach ($errors as $error): ?>
  <div class="bg-red-500 text-white p-4 mb-4 rounded-lg mt-4">
    <?php echo htmlspecialchars($error); ?>
  </div>

<?php endforeach; ?>


<form action="/blogs/submitCategory" method="POST" class="bg-white p-8 rounded-lg shadow-lg space-y-6 mt-2 max-w-6xl mx-auto">

  <!-- Title Field -->
  <div class="mb-6">
    <label for="title" class="block text-lg font-medium text-gray-700">New Category Title:</label>
    <input type="text" id="title" name="title" class="mt-2 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
  </div>

  <!-- Submit Button -->
  <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
    Create new category
  </button>
</form>


<!-- given this form template, add functionality to show error above the form as red background color and text color white  -->
