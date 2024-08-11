<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;
use App\Controllers\BlogController;

// unset($_SESSION);
// session_unset();


echo ("<pre>");
// var_dump($_SESSION);
echo ("</pre>");

$router = new Router();
$router->add('/', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('/login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('/register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('/dashboard', ['controller' => 'DashboardController', 'action' => 'index']);
$router->add('/blogs', ['controller' => 'DashboardController', 'action' => 'showAllBlogs']);
$router->add('/blogs/create', ['controller' => 'DashboardController', 'action' => 'createBlog']);
$router->add('/logout', ['controller' => 'AuthController', 'action' => 'logout']);

if ($_SERVER['REQUEST_URI'] === "/blogs/create" && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $contoller = new BlogController();
  $contoller->submitBlog();
}

// echo $_SERVER['REQUEST_URI'][1];

$router->dispatch(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
