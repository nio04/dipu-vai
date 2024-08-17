<?php

namespace Core;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\BlogController;
use App\Controllers\BlogActionController;
use App\Controllers\BlogEditController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;

class Router {
  /**
   * Array to store all registered routes
   * 
   * @var array
   */
  protected array $routes = [];
  protected string $uri;
  protected $params;

  /**
   * Manually add routes in this method.
   * Automatically registers routes in the router
   */
  public function autoRegisterRoute(): void {
    $this->routes['/'] = [
      'controller' => HomeController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    $this->routes['/login/submit'] = [
      'controller' => AuthController::class,
      'action' => 'submit',
      'httpMethod' => 'post'
    ];
    $this->routes['/login'] = [
      'controller' => AuthController::class,
      'action' => 'login',
      'httpMethod' => 'get'
    ];

    $this->routes['/register'] = [
      'controller' => AuthController::class,
      'action' => 'register',
      'httpMethod' => 'get'
    ];

    $this->routes['/viewallposts'] = [
      'controller' => BlogController::class,
      'action' => 'viewallposts',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/search'] = [
      'controller' => BlogActionController::class,
      'action' => 'search',
      'httpMethod' => 'post'
    ];
    $this->routes['/blogs/sort'] = [
      'controller' => BlogActionController::class,
      'action' => 'sort',
      'httpMethod' => 'get'
    ];
    $this->routes['/dashboard'] = [
      'controller' => DashboardController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/show'] = [
      'controller' => BlogController::class,
      'action' => 'show',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/like'] = [
      'controller' => BlogActionController::class,
      'action' => 'like',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/createComment'] = [
      'controller' => BlogActionController::class,
      'action' => 'createComment',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/create'] = [
      'controller' => BlogEditController::class,
      'action' => 'create',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/edit'] = [
      'controller' => BlogEditController::class,
      'action' => 'edit',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/submit'] = [
      'controller' => BlogEditController::class,
      'action' => 'submit',
      'httpMethod' => 'post'
    ];
    $this->routes['/blogs/update'] = [
      'controller' => BlogEditController::class,
      'action' => 'update',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs/delete'] = [
      'controller' => BlogEditController::class,
      'action' => 'delete',
      'httpMethod' => 'post'
    ];
    $this->routes['/logout'] = [
      'controller' => AuthController::class,
      'action' => 'logout',
      'httpMethod' => 'post'
    ];
    $this->routes['/category'] = [
      'controller' => CategoryController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    $this->routes['/category/create'] = [
      'controller' => CategoryController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    $this->routes['/category/edit'] = [
      'controller' => CategoryController::class,
      'action' => 'edit',
      'httpMethod' => 'get'
    ];
    $this->routes['/category/delete'] = [
      'controller' => CategoryController::class,
      'action' => 'delete',
      'httpMethod' => 'get'
    ];
    $this->routes['/category/submit'] = [
      'controller' => CategoryController::class,
      'action' => 'submit',
      'httpMethod' => 'post'
    ];
    $this->routes['/blogs'] = [
      'controller' => BlogController::class,
      'action' => 'viewallposts',
      'httpMethod' => 'get'
    ];
    $this->routes['/blogs'] = [
      'controller' => BlogController::class,
      'action' => 'viewAllBlogsAsAdmin',
      'httpMethod' => 'get'
    ];
  }

  /**
   * Responsible for dispatching routes
   * 
   * @throws \Exception
   * @return void
   */
  public function dispatch(): void {
    $uri = rtrim($_SERVER['REQUEST_URI'], '/');
    $httpMethod = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
    // Extract parameters and update URI
    $this->extractParams($uri);

    foreach ($this->routes as $routeUri => $routeDetails) {
      // Check if the current route matches the requested URI
      if ($this->matchUri($routeUri, $this->uri)) {
        // Validate the HTTP method
        $method = $routeDetails['httpMethod'] ?? 'get';

        if ($httpMethod !== $method) {
          throw new \Exception("HTTP method not allowed for this route.");
        }

        // Instantiate the controller
        $controller = new $routeDetails['controller'];

        // Extract action and params from the URI
        [$action, $params] = $this->extractActionAndParams($routeUri, $uri);
        $action = $routeDetails['action'] ?? $action;

        // Default action to 'index' if not provided
        if (empty($action)) {
          $action = 'index';
        }

        // Call the action on the controller
        if (method_exists($controller, $action)) {
          call_user_func_array([$controller, $action], [$this->params]);
        } else {
          throw new \Exception("Action $action not found in controller.");
        }

        return; // Exit after the first successful route match
      }
    }

    throw new \Exception("Route not found.");
  }

  /**
   * Extracts parameters and updates the URI
   * 
   * @param string $uri
   */
  private function extractParams(string $uri) {
    // Split the URI into segments
    $uriSegments = explode('/', trim($uri, '/'));

    // Initialize variable for the numeric third segment
    $params = null;

    // Check if the third segment is numeric
    if (isset($uriSegments[2])) {
      // Extract the third segment
      $params = $uriSegments[2];

      // Remove the third segment from the URI segments
      unset($uriSegments[2]);

      // Re-index the array to prevent gaps
      $uriSegments = array_values($uriSegments);
    }

    // Rebuild the URI without the numeric third segment
    $uri = implode('/', $uriSegments);
    if ($uri === '') {
      $uri = '/';
    }

    $uri = "/" . $uri;

    $this->uri = $uri;
    $this->params = $params;

    // Return the updated URI and parameters
    // return [$uri, $numericParam ? $numericParam : []];
  }

  /**
   * Matches the request URI against a registered route URI
   * 
   * @param string $routeUri
   * @param string $requestUri
   * @return bool
   */
  private function matchUri(string $routeUri, string $requestUri): bool {
    // echo $routeUri;
    // Remove trailing slashes for matching purposes
    $routeUri = rtrim($routeUri, '/');
    $requestUri = rtrim($requestUri, '/');

    // Exact match
    return $routeUri === $requestUri;
  }

  /**
   * Extracts action and parameters from the request URI based on the route URI
   * 
   * @param string $routeUri
   * @param string $requestUri
   * @return array [string, array]
   */
  private function extractActionAndParams(string $routeUri, string $requestUri): array {
    $routeSegments = explode('/', trim($routeUri, '/'));
    $requestSegments = explode('/', trim($requestUri, '/'));

    $action = '';
    $params = [];

    // Check if URI segments exceed route segments
    if (count($requestSegments) > count($routeSegments)) {
      $action = $requestSegments[count($routeSegments)] ?? null;
      $remainingSegments = array_slice($requestSegments, count($routeSegments));
      foreach ($remainingSegments as $segment) {
        // Check if the segment is a digit (parameter)
        if (preg_match('/^\d+$/', $segment)) {
          $params[] = $segment;
        }
      }
    }

    return [$action, $params];
  }
}
