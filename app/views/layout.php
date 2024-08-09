<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'My Application'; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
  <header class="bg-blue-500 text-white p-4">
    <h1 class="text-3xl">My Application</h1>
  </header>
  <main class="p-8">
    <?php include $content; ?>
  </main>
  <footer class="bg-gray-800 text-white p-4 text-center">
    &copy; <?php echo date('Y'); ?> My Application
  </footer>
</body>

</html>
