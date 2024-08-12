<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
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
$router->addRoute("/viewallposts", BlogController::class, "viewallposts");
$router->addRoute("/dashboard", DashboardController::class);
$router->addRoute("/blogs", BlogController::class, "showAllBlogs");
$router->addRoute("/blogs/show", BlogController::class); // single blog post
$router->addRoute("/blogs/create", BlogController::class);
$router->addRoute("/blogs/edit", BlogController::class);
$router->addRoute("/blogs/submit", BlogController::class);
$router->addRoute("/blogs/update", BlogController::class);
$router->addRoute("/blogs/delete", BlogController::class);
$router->addRoute("/logout", AuthController::class, "logout");

$uri = $_SERVER["REQUEST_URI"];
$router->dispatch($uri);
