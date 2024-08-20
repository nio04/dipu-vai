<?php

namespace Core;

use App\Traits\SessionTrait;

class Controller {
  use SessionTrait;

  protected $view;
  protected $isLoggedIn;
  protected $username;
  protected $isAdmin;
  protected $setShowCreateNewPost;
  protected $setShowCreateNewCategory;
  protected $showUserName;

  public function __construct() {
    $this->view = new View();

    // Check if a user is logged in from the session
    $this->isLoggedIn = $this->getSession(['user', 'username']);

    // $username = $isLoggedIn ? htmlspecialchars($_SESSION['user'][0]->username) : 'Guest';
    $this->username = $this->isLoggedIn ? htmlspecialchars($this->getSession(['user', 'username'])) : 'Guest';

    // Check if a user is logged in from the session
    $this->isAdmin = $this->hasSession(['settings', 'admin']);

    $this->setShowCreateNewPost = $this->hasSession('user') && $_SERVER['REQUEST_URI'] === '/blogs' || $_SERVER['REQUEST_URI'] === '/dashboard';

    $this->setShowCreateNewCategory = $this->hasSession('user') && $_SERVER['REQUEST_URI'] === '/category';

    $this->showUserName = $this->getSession(['user', 'username'], 'Guest');
  }
}
