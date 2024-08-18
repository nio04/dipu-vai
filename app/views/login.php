<?php loadPartials("header") ?>

<div class="w-2/5 mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-12">
  <h2 class="text-2xl font-bold mb-6">Login</h2>

  <?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
      <div class="bg-red-500 text-white p-4 mb-1 rounded">
        <?php echo $error; ?>
      </div>
    <?php endforeach ?>
  <?php endif; ?>

  <!-- Form container with relative positioning -->
  <form method="POST" action="/login/submit" class="mt-4 relative">
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="additional_token">Additional Token</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="additional_token" name="additional_token" type="text">
    </div>

    <!-- Login button -->
    <div class="flex">
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Login</button>
    </div>

    <!-- Register button with absolute positioning -->
    <div class="absolute bottom-0 right-0 mt-4">
      <a href="/register/load" class="bg-green-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">go to Register</a>
    </div>
  </form>
</div>

<?php loadPartials("footer") ?>
