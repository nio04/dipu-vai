<?php loadPartials("header") ?>

<?php


function vd($data) {
  $trace = debug_backtrace();
  $caller = $trace[0];
  echo '<br><br>' . 'File: ' . $caller['file'] . '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Line: ' . $caller['line'] . '<br>';
  echo '<div class="var-dump">' . nl2br(htmlspecialchars(var_export($data, true))) . '</div>';
}

vd($errors);


?>

<div class="w-2/5 mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-12">
  <h2 class="text-2xl font-bold mb-6">Register</h2>

  <?php if (isset($errors)): ?>
    <?php foreach ($errors as $error):  ?>
      <div class="bg-red-500 text-white p-4 mb-4 rounded">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <form method="POST" action="/register/submit">
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text">
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password">
    </div>
    <div class="flex justify-between">
      <div class="flex items-center justify-between">
        <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Register</button>
      </div>
      <div class="flex items-center justify-between">
        <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Go to LOGIN</a>
      </div>
    </div>
  </form>
</div>

<?php loadPartials("footer") ?>
