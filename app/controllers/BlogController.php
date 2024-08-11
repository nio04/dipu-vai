<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use Core\Controller;
use Core\Model;

class BlogController {
  use ValidationTrait;
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
