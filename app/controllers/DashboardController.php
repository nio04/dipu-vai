<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Blog;
use App\Controllers\BlogController;

class DashboardController extends Controller {
  private $blog;

  public function index() {

    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    // load all the posts from the database
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();

    // Render the dashboard view
    $this->view->render('dashboard', ['blogs' => $allBlogs]);
  }

  public function showAllBlogs() {
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();
    $this->view->render('dashboard', ['blogs' => $allBlogs]);
  }

  public function showBlog($id) {
    $this->blog = new Blog();
    $post = $this->blog->getTheBlog($id);
    $this->view->render('blog', ['post' => $post]);
  }

  public function create() {
    // $blogData = new BlogController();
    // $blogData->submitBlog();
    $this->view->render('dashboard');
  }

  public function edit($id) {
    // fetch data from the database by id   
    $this->blog = new Blog();
    $post = $this->blog->getTheBlog($id);
    // load a new view and pass the fetched data
    $this->view->render("edit", ["post" => $post]);
  }

  public function updateBlog() {
    $this->blog = new Blog();
    $this->blog->update($_POST);
    header("Location: /blogs");
  }

  public function delete($id) {
    $this->blog = new Blog();
    $post = $this->blog->deleteTheBlog($id);
    header("Location: /blogs");
  }
}
