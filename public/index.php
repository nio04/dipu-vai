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


echo ("<pre>");
// var_dump($_SESSION);
echo ("</pre>");

$router = new Router();

$router->addRoute("", HomeController::class);
$router->addRoute("/login", AuthController::class, "login");
$router->addRoute("/register", AuthController::class, "register");
$router->addRoute("/dashboard", DashboardController::class);
$router->addRoute("/blogs", DashboardController::class, "showAllBlogs");
$router->addRoute("/blogs/show", DashboardController::class,);
$router->addRoute("/blogs/create", DashboardController::class, "create");
$router->addRoute("/blogs/edit", DashboardController::class, "edit");
$router->addRoute("/blogs/submit", DashboardController::class, "submit");
$router->addRoute("/blogs/update", DashboardController::class, "updateBlog");
$router->addRoute("/blogs/delete", DashboardController::class, "delete");
$router->addRoute("/logout", AuthController::class, "logout");

$uri = $_SERVER["REQUEST_URI"];
$router->dispatch($uri);
