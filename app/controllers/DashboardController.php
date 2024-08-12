<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Blog;

class DashboardController extends Controller {
  private $blog;

  public function index() {

    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    // load all the posts data from the database
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();

    // Render the dashboard view
    $this->view->render('dashboard', ['blogs' => $allBlogs]);
  }
}
