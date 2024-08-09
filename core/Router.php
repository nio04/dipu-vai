<?php

namespace Core;

class Router {
  protected $routes = [];

  public function add($route, $params = []) {
    $this->routes[$route] = $params;
  }

  public function dispatch($url) {
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
