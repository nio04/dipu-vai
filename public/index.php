<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;

// unset($_SESSION);
// session_unset();


// echo ("<pre>");
// var_dump($_SESSION);
// echo ("</pre>");

$router = new Router();

$router->addRoute("", HomeController::class);
$router->addRoute("/login", AuthController::class, "login");
$router->addRoute("/register", AuthController::class, "register");
$router->addRoute("/viewallposts", BlogController::class, "viewallposts"); // for non-admin
$router->addRoute("/blogs/search", BlogController::class);
$router->addRoute("/blogs/sort", BlogController::class);
$router->addRoute("/dashboard", DashboardController::class);
$router->addRoute("/blogs", BlogController::class, "showAllBlogs"); // for admin
$router->addRoute("/blogs/show", BlogController::class); // single blog post
$router->addRoute("/blogs/like", BlogController::class); // like blog post
$router->addRoute("/blogs/createComment", BlogController::class); // create commnet
$router->addRoute("/blogs/create", BlogController::class);
$router->addRoute("/blogs/edit", BlogController::class);
$router->addRoute("/blogs/submit", BlogController::class);  // submit blog
$router->addRoute("/blogs/update", BlogController::class);
$router->addRoute("/blogs/delete", BlogController::class);
$router->addRoute("/logout", AuthController::class, "logout");
$router->addRoute("/category", CategoryController::class);
$router->addRoute("category/submitCategory", CategoryController::class);


$uri = $_SERVER["REQUEST_URI"];
$router->dispatch($uri);
