<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();

// unset($_SESSION['user']);
// unset($_SESSION['settings']);

echo ("<pre>");
var_dump($_SESSION);
echo ("</pre>");
