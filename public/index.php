<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();

// unset($_SESSION['users']);
// unset($_SESSION['settings']);
// unset($_SESSION['nested_key']);
// session_destroy();

// echo ("<pre>");
// var_dump($_SESSION);
// echo ("</pre>");
