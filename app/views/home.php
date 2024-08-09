<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <!-- Include TailwindCSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="text-center p-8 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold mb-4"><?php echo $message; ?></h1>

    <div class="space-y-4">
      <a href="/login" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Login</a>
      <a href="/register" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300">Register</a>
    </div>
  </div>

</body>

</html>
