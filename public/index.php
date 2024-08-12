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

$router->dispatch();
