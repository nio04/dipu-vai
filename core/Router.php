<?php

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\DashboardController;

class Router {
  protected $routes = [];

  public function __construct() {
    $this->routes[] = [
      "/" => HomeController::class,
      "/login" => AuthController::class,
      "/register" => AuthController::class,
      "/dashboard" => DashboardController::class,
      "/blogs" => DashboardController::class,
      "/blogs/show" => DashboardController::class,
      "/blogs/create" => DashboardController::class,
      "/logout" => AuthController::class,
    ];
  }

  public function add($route, $params = []) {
    $this->routes[$route] = $params;
  }

  public function dispatch($url) {
    $uri = parse_url(trim($_SERVER['REQUEST_URI'], "/"), PHP_URL_PATH);
    $parts = explode('/', $uri);
    $params = array_slice($parts, 1);

    if (array_key_exists($url, $this->routes)) {
      $controllerName = $this->routes[$url]['controller'];
      $action = $this->routes[$url]['action'];

      // Define the namespace for controllers
      $controllerNamespace = 'App\\Controllers\\';
      $fullControllerName = $controllerNamespace . $controllerName;

      // Check if the class exists
      if (class_exists($fullControllerName)) {
        $controller = new $fullControllerName();

        // Check if the method exists
        if (method_exists($controller, $action)) {
          $controller->$action();
        } else {
          echo "Method $action not found in controller $fullControllerName.";
        }
      } else {
        echo "Controller class $fullControllerName not found.";
      }
    } else {
      echo "No route matched.";
    }
  }
}
