<?php

session_start();

require "../vendor/autoload.php";
require "../helpers.php";

use Core\Router;

$router = new Router();
$router->autoRegisterRoute();
$router->dispatch();
