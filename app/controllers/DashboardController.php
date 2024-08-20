<?php

namespace App\Controllers;

use App\Traits\SessionTrait;
use Core\Controller;
use App\Models\Blog;

class DashboardController extends Controller {
  use SessionTrait;

  private $blog;

  public function index() {

    // Check if user is logged in
    if (!$this->hasSession('user')) {
      header('Location: /login');
      exit;
    }
    // load all the posts data from the database
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();

    // Render the dashboard view
    return $this->view->render('dashboard', ['blogs' => $allBlogs, 'showCreatePostBtn' => $this->setShowCreateNewPost, 'showUserName' => $this->showUserName]);
  }
}
