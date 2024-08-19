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
   * Stores all registered routes.
   *
   * @var array
   */
  protected array $routes = [];

  /**
   * Stores the processed URI.
   *
   * @var string
   */
  protected string $uri;

  /**
   * Stores extracted parameters from the URI.
   *
   * @var mixed
   */
  protected $params;

  /**
   * Automatically registers routes by mapping URIs to controllers and actions.
   */
  public function autoRegisterRoute(): void {
    // Home routes
    $this->routes['/'] = [
      'controller' => HomeController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];

    // Authentication routes
    $this->routes['/login/submit'] = [
      'controller' => AuthController::class,
      'action' => 'loginSubmit',
      'httpMethod' => 'post'
    ];
    $this->routes['/login'] = [
      'controller' => AuthController::class,
      'action' => 'login',
      'httpMethod' => 'get'
    ];
    $this->routes['/register/load'] = [
      'controller' => AuthController::class,
      'action' => 'registerLoadView',
      'httpMethod' => 'get'
    ];
    $this->routes['/register/submit'] = [
      'controller' => AuthController::class,
      'action' => 'registerSubmit',
      'httpMethod' => 'post'
    ];
    $this->routes['/logout'] = [
      'controller' => AuthController::class,
      'action' => 'logout',
      'httpMethod' => 'post'
    ];

    // Blog routes
    $this->routes['/blogs'] = [
      'controller' => BlogController::class,
      'action' => 'viewAllBlogsAsAdmin',
      'httpMethod' => 'get'
    ];
    $this->routes['/viewallblogs'] = [
      'controller' => BlogController::class,
      'action' => 'viewallblogs',
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
      'httpMethod' => 'post'
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
      'httpMethod' => 'post'
    ];
    $this->routes['/blogs/delete'] = [
      'controller' => BlogEditController::class,
      'action' => 'delete',
      'httpMethod' => 'post'
    ];

    // Dashboard route
    $this->routes['/dashboard'] = [
      'controller' => DashboardController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];

    // Category routes
    $this->routes['/category'] = [
      'controller' => CategoryController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    $this->routes['/category/create'] = [
      'controller' => CategoryController::class,
      'action' => 'create',
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
  }

  /**
   * Dispatches the request to the appropriate controller and action based on the URI.
   *
   * @throws \Exception
   */
  public function dispatch(): void {
    $uri = rtrim($_SERVER['REQUEST_URI'], '/');
    $httpMethod = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');

    $this->extractParams($uri);

    foreach ($this->routes as $routeUri => $routeDetails) {

      if ($this->matchUri($routeUri, $this->uri)) {
        if ($httpMethod !== $routeDetails['httpMethod']) {
          throw new \Exception("HTTP method not allowed for this route.");
        }

        $controller = new $routeDetails['controller'];
        $action = $routeDetails['action'];
        $action = $routeDetails['action'] ?? 'index';

        if (method_exists($controller, $action)) {
          call_user_func_array([$controller, $action], [$this->params]);
        } else {
          throw new \Exception("Action $action not found in controller.");
        }

        return;
      }
    }

    loadView("pageNotFound");
    // throw new \Exception("Route not found.");
  }

  /**
   * Extracts parameters from the URI and updates the internal URI state.
   *
   * @param string $uri
   */
  private function extractParams(string $uri): void {
    $uriSegments = explode('/', trim($uri, '/'));

    if (isset($uriSegments[2])) {
      $this->params = $uriSegments[2];
      unset($uriSegments[2]);
      $uriSegments = array_values($uriSegments);
    }

    $uri = implode('/', $uriSegments) ?: '/';
    $this->uri = "/$uri";
  }

  /**
   * Checks if the request URI matches a registered route URI.
   *
   * @param string $routeUri
   * @param string $requestUri
   * @return bool
   */
  private function matchUri(string $routeUri, string $requestUri): bool {
    return rtrim($routeUri, '/') === rtrim($requestUri, '/');
  }
}
