<?php

namespace Core;

class Router {
  protected $routes = [];

  /**
   * Add route to the Router
   * @param string $uri The URI path (e.g., '/login', '/blogs/show').
   * @param mixed $controllerClass controller class 
   * @param string|null $action the action method to be call
   * @return void
   */
  public function addRoute($uri, $controllerClass = null, $defaultAction = 'index') {
    $uri = trim($uri, "/");

    // Explode the URI into segments
    $segments = explode("/", $uri);

    // Extract the controller class name from the first segment or use the provided controller class
    $controllerClass = $controllerClass ?? $segments[0];

    // Extract the action from the next segment or use the default action
    $action = isset($segments[1]) ? $segments[1] : $defaultAction;

    // Store the route information
    $this->routes[$uri] = [
      $controllerClass,
      $action
    ];
  }



  /*
 public function addRoute($uri, $controllerClass, $action = 'index') {
    $uri = trim($uri, "/");
    $this->routes[$uri] = [$controllerClass, $action];
  }
*/


  // dispatch the request based on the current uri
  public function dispatch($uri) {
    // remove leading and trailling slashes and explode it into parts
    $uri = trim($uri, "/");
    $uriParts = explode("/", $uri);

    // get the controller name from the first part of the uri
    $routeKey = $uriParts[0] ?? '';

    // check if the controller exist on the route
    if (isset($this->routes[$routeKey])) {
      list($controllerClass, $defaultAction) = $this->routes[$routeKey];

      if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        // if there is no action then use the default action
        $action = $uriParts[1] ??  $defaultAction;

        // slice the params part from the uri part
        $params = array_slice($uriParts, 2);

        // flags to store for check if params is digit or not
        $paramIsDigit = true;

        // if there is any elements on the $params array then enter on the block
        if (count($params) > 0) {
          // regex for checking if the param is digit or not
          preg_match("/^\d+$/", $params[0]) ? $paramIsDigit = true : $paramIsDigit = false;
          // if params is digit convert it and update the param variable
          if ($paramIsDigit) {
            $params = (int) $params[0];
          }
        }

        if (method_exists($controller, $action)) {
          // if method_exists then execute the method from the controller wilth param
          call_user_func(array($controller, $action), $params);
        } else {
          echo "action: $action was not found in calss: {$this->routes[$routeKey][0]}";
        }
      } else {
        echo "controller: $controllerClass was not found";
      }
    } else {
      echo "route key: $routeKey was not found";
    }
  }
}
