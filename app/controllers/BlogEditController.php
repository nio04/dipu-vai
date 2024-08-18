<?php

namespace App\Controllers;

use Core\Controller;
use App\Controllers\BlogController;
use App\Models\Blog;
use App\Controllers\BlogActionController;
use App\Controllers\CategoryController;

class BlogEditController extends Controller {
  public $blogAction;
  public $blog;
  public $category;

  public function __construct() {
    $this->blogAction = new BlogActionController();
    $this->blog = new Blog();
    $this->category = new CategoryController();
    parent::__construct();
  }

  function create() {
    $categories = $this->category->load();
    $this->view->render('createBlog', ['categories' => $categories]);
  }


  function edit($id) {
    // fetch data from the database by id   
    $blog = $this->blog->getTheBlog($id);
    // load a new view and pass the fetched data
    $this->view->render("editBlog", ["blog" => $blog]);
  }

  public function update() {
    $this->blog->update($_POST);
    header("Location: /blogs");
  }

  public function delete($id) {
    $post = $this->blog->deleteTheBlog($id);
    header("Location: /blogs");
  }

  public function submit() {
    $this->blogAction->submitBlog();
    $this->view->render('dashboard');
  }
}
