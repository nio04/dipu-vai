<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use Core\Controller;
use Core\Model;
use App\Models\Blog;

class BlogController extends Controller {
  use ValidationTrait;

  public $blog;

  // for dashboard
  public function showAllBlogs() {
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();
    $this->view->render('dashboard', ['blogs' => $allBlogs]);
  }

  // not for dashboard
  public function viewallposts() {
    $this->blog = new Blog();
    $allBlogs = $this->blog->getAllBlogs();
    $this->view->render('viewallposts', ['blogs' => $allBlogs]);
  }

  public function show($id) {
    $this->blog = new Blog();
    $post = $this->blog->getTheBlog($id);

    $this->view->render('blog', ['post' => $post]);
  }

  public function create() {
    $this->view->render('dashboard');
  }

  public function edit($id) {
    // fetch data from the database by id   
    $this->blog = new Blog();
    $post = $this->blog->getTheBlog($id);
    // load a new view and pass the fetched data
    $this->view->render("edit", ["post" => $post]);
  }

  public function update() {
    $this->blog = new Blog();
    $this->blog->update($_POST);
    header("Location: /blogs");
  }

  public function delete($id) {
    $this->blog = new Blog();
    $post = $this->blog->deleteTheBlog($id);
    header("Location: /blogs");
  }

  public function submit() {
    // $blogData = new BlogController();
    $this->submitBlog();
    $this->view->render('dashboard');
  }

  public function submitBlog() {
    $errors = [];

    $title = $this->sanitizeInput($_POST['title']);
    $description = $this->sanitizeInput($_POST['description']);
    $tags = $this->sanitizeInput($_POST['tags']);


    if (empty($title) || empty($description) || empty($tags)) {
      $errors['field_require'] = 'all the filelds must be filled';
    }


    // if error exist redirect to create-blog route again with error
    if (!empty($errors)) {
      header('Location: /blogs/create');
      $_SESSION['blog_create_err'] = $errors;
    } else {
      $data =
        ['user_id' => $_SESSION['user']['id'], 'title' => $title, "description" => $description, "tags" => $tags, "created_at" => timestamp()];

      $blog = new Model();
      $blog->query("INSERT INTO blogs (user_id, title, description, tags, created_at) VALUES (:user_id, :title, :description, :tags, :created_at)", $data);

      header('Location: /blogs');
      unset($_SESSION['blog_create_err']);
    }
  }
}
