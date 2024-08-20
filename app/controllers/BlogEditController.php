<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use Core\Controller;
use App\Controllers\BlogController;
use App\Models\Blog;
use App\Controllers\BlogActionController;
use App\Controllers\CategoryController;

class BlogEditController extends Controller {
  use ValidationTrait;

  public $blogAction;
  public $blog;
  public $category;
  public $categoriesLists;

  public function __construct() {
    $this->blogAction = new BlogActionController();
    $this->blog = new Blog();
    $this->category = new CategoryController();
    parent::__construct();
  }

  function create() {
    $this->categoriesLists = $this->category->load();
    return $this->view->render('createBlog', ['categories' => $this->categoriesLists, 'showUserName' => $this->showUserName]);
  }


  function edit($id) {
    // fetch data from the database by id   
    $blog = $this->blog->getTheBlog($id)[0];

    // load a new view and pass the fetched data
    return $this->view->render("editBlog", ['id' => $blog->id, "title" => $blog->title, "description" => $blog->description, 'tags' => $blog->tags]);
  }

  public function update() {
    $blogId = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];

    // SANITIZE
    $this->sanitize([$blogId, $title, $description, $tags]);

    // check empty
    $requiredFields = ['title', 'description'];
    $emptyCheck = $this->isEmpty(['title' => $title, 'description' => $description,], $requiredFields);
    if (is_array($emptyCheck) && isset($emptyCheck[0])) {
      return $this->view->render('editBlog', ['errors' => $emptyCheck, 'id' => $_POST['id'], 'title' => $title, 'tags' => $tags, 'description' => $description]);
    }

    $this->blog->update($blogId, $title, $description, $tags);
    header("Location: /blogs");
  }

  public function delete($id) {
    $post = $this->blog->deleteTheBlog($id);
    header("Location: /blogs");
  }

  public function submit() {
    return $this->blogAction->submitBlog($this->categoriesLists);
  }
}
