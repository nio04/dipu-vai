<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;
// use App\Controllers\HomeController;
// use App\Controllers\AuthController;
// use App\Controllers\BlogController;
// use App\Controllers\BlogActionController;
// use App\Controllers\BlogEditController;
// use App\Controllers\CategoryController;
// use App\Controllers\DashboardController;

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();

// $router->addRoute("", HomeController::class);
// $router->addRoute("/login", AuthController::class, "login");
// $router->addRoute("/register", AuthController::class, "register");
// $router->addRoute("/viewallposts", BlogController::class, "viewallposts"); // for non-admin
// $router->addRoute("/blogs/search", BlogActionController::class);
// $router->addRoute("/blogs/sort", BlogActionController::class);
// $router->addRoute("/dashboard", DashboardController::class);
// $router->addRoute("/blogs/show", BlogController::class); // single blog post
// $router->addRoute("/blogs/like", BlogActionController::class); // like blog post
// $router->addRoute("/blogs/createComment", BlogActionController::class); // create commnet
// $router->addRoute("/blogs/create", BlogEditController::class);
// $router->addRoute("/blogs/edit", BlogEditController::class);
// $router->addRoute("/blogs/submit", BlogEditController::class);  // submit blog
// $router->addRoute("/blogs/update", BlogEditController::class);
// $router->addRoute("/blogs/delete", BlogEditController::class);
// $router->addRoute("/logout", AuthController::class, "logout");
// $router->addRoute("/category", CategoryController::class);
// $router->addRoute("category/submitCategory", CategoryController::class);

// $router->addRoute("/blogs", BlogController::class, "viewAllBlogsAsAdmin"); // for admin
// $uri = $_SERVER["REQUEST_URI"];
// $router->dispatch($uri);


// unset($_SESSION);
// session_unset();

// echo ("<pre>");
// var_dump($_SESSION);
// echo ("</pre>");
