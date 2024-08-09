<?php

session_start();

require "../vendor/autoload.php";

// require_once '../core/Router.php';
// require_once '../app/controllers/HomeController.php';

use Core\Router;

$router = new Router();
$router->add('/', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('/login', ['controller' => 'AuthController', 'action' => 'login']);
$router->add('/register', ['controller' => 'AuthController', 'action' => 'register']);
$router->add('/dashboard', ['controller' => 'DashboardController', 'action' => 'index']);

$router->dispatch($_SERVER['REQUEST_URI']);
