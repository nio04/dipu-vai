<?php

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\DashboardController;

class Router {
  protected $routes;
  protected $methodMappings;

  public function __construct() {
    $this->routes = [
      "/" => HomeController::class,
      "/login" => AuthController::class,
      "/register" => AuthController::class,
      "/dashboard" => DashboardController::class,
      "/blogs" => DashboardController::class,
      "/blogs/show" => DashboardController::class,
      "/blogs/create" => DashboardController::class,
      "/blogs/edit" => DashboardController::class,
      "/blogs/submit" => BlogController::class,
      "/blogs/update" => DashboardController::class,
      "/blogs/delete" => DashboardController::class,
      "/logout" => AuthController::class,
    ];

    $this->methodMappings = [
      '/login' => 'login',
      '/logout' => 'logout',
      '/register' => 'register',
      '/blogs' => 'showAllBlogs',
      '/blogs/show' => 'showBlog',
      '/blogs/create' => 'create',
      "/blogs/edit" => "edit",
      '/blogs/submit' => 'submitBlog',
      "/blogs/update" => "updateBlog",
      "/blogs/delete" => "delete"
    ];
  }

  public function dispatch() {
    $request = trim($_SERVER['REQUEST_URI'], "/"); // Get the current URI and trim slashes
    $parts = explode("/", $request); // Break down the URI into parts

    // Find the base path without dynamic segments
    $basePath = '/' . $parts[0];
    if (isset($parts[1])) {
      $basePath .= '/' . $parts[1];
    }

    // Check if the base route is registered
    if (array_key_exists($basePath, $this->routes)) {
      $controllerClass = $this->routes[$basePath];

      // Check if the controller class exists
      if (class_exists($controllerClass)) {
        $controller = new $controllerClass(); // Instantiate the controller

        // Determine the method to call based on the route or use the default 'index'
        $methodName = $this->methodMappings[$basePath] ?? 'index';

        // Handle any additional parameters (dynamic segments)
        $params = array_slice($parts, 2);

        // Check if the method exists within the controller
        if (method_exists($controller, $methodName)) {
          // Call the method with any additional parameters
          call_user_func_array([$controller, $methodName], $params);
        } else {
          http_response_code(404);
          echo "Method '{$methodName}' does not exist in controller '{$controllerClass}'.";
        }
      } else {
        http_response_code(404);
        echo "Controller class '{$controllerClass}' does not exist.";
      }
    } else {
      http_response_code(404);
      echo "Route '{$request}' not found.";
    }
  }
}
