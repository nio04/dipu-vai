<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\ValidationTrait;
use Core\Controller;
use Core\Model;
use App\Models\Blog;

class BlogController extends Controller {
  use ValidationTrait;

  public $blog;

  public function __construct() {
    $this->blog = new Blog();
    parent::__construct();
  }

  // for dashboard
  public function showAllBlogs() {
    $allBlogs = $this->blog->getAllBlogs();
    $this->view->render('dashboard', ['blogs' => $allBlogs]);
  }

  // not for dashboard
  public function viewallposts() {
    $allBlogs = $this->blog->getAllBlogs();
    $this->view->render('viewallposts', ['blogs' => $allBlogs]);
  }

  public function show($id) {
    // load the post data
    $blog = $this->blog->getTheBlog($id);

    // load comments
    $comments = $this->loadComments($id);

    // load username for the comments
    $usernameForComments = $this->loadUsernameForCommnet($comments);

    // render specific blog view
    $this->view->render('blog', ['blog' => $blog, 'comments' => $usernameForComments]);
  }

  public function loadComments($id) {
    return $this->blog->loadCommentForBlog($id);
  }

  public function loadUsernameForCommnet($comments) {
    $user = new User();
    $user_id = [];
    $username = [];

    // get all the userid from comments
    foreach ($comments as $comment) {
      $user_id[] = $comment->user_id;
    }

    // get username from DB & store
    foreach ($user_id as $id) {
      $username[] = $user->getUser($id);
    }

    // store both  comments and username in array of object
    $combineCommentAndUsername = [];

    foreach ($username as $user) {
      foreach ($comments as $comment) {
        if ($user->id === $comment->user_id) {
          // Push an array containing both the comment and user data as objects into $newData
          $combineCommentAndUsername[] = [
            'comment' => (object) $comment,
            'user' => (object) $user
          ];
        }
      }
    }


    return $combineCommentAndUsername;
  }

  public function createComment($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $commentData = $this->sanitizeInput($_POST['comment']);
      // $commentData = $this->checkEmpty([$commentData]);

      if ($commentData) {
        $this->blog->createCommnentForBlog($id, $commentData);
        header('location: /blogs/show/' . $id);
      } else {
        header('location: /blogs/show/' . $id);
        // show error
      }
    }
  }

  public function like($id) {
    // get the current blog like count.
    $post = $this->blog->getTheBlog($id);

    // echo ("<pre>");
    // var_dump($post);
    // echo ("</pre>");

    // update like count
    $oldLikeCount = $post->like_count;
    $newLikeCount = $oldLikeCount + 1;

    // push the data to database
    $data = [
      'id' => $id,
      'like_count' => $newLikeCount,
      'user_id' => $_SESSION['user']['id']
    ];
    $this->blog->updateLike($data);

    header("Location:/blogs/show/$id");
  }

  public function create() {
    $this->view->render('dashboard');
  }

  public function edit($id) {
    // fetch data from the database by id   
    $post = $this->blog->getTheBlog($id);
    // load a new view and pass the fetched data
    $this->view->render("edit", ["post" => $post]);
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
