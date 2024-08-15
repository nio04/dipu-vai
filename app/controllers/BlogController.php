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

  // helper class: add author object [name & id] to the blogs 
  function appendAuthorToBlog($allBlogs) {
    // Prepare all blog IDs to get the author name
    $allBlogsId = [];

    foreach ($allBlogs as $value) {
      // Directly add the user_id to the array
      $allBlogsId[] = $value->user_id;
    }

    // get author name method
    $authorNames = $this->getBlogAuthorName($allBlogsId);

    // Loop through allBlogs and match user_id with authorNames
    foreach ($allBlogs as $blog) {
      foreach ($authorNames as $author) {
        if ($blog->user_id === $author->id) {
          // Add the matched author object to the current blog object
          $blog->author = $author;
          break; // Exit inner loop once match is found
        }
      }
    }

    return $allBlogs;
  }

  // not for dashboard
  public function viewallposts() {
    $allBlogs = $this->blog->getAllBlogs();

    // add author object to the blog object [append]
    $allBlogs = $this->appendAuthorToBlog($allBlogs,);

    $this->view->render('viewallposts', ['blogs' => $allBlogs]);
  }

  function search() {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      // sanitize
      $searchInput = $this->sanitizeInput($_POST['search']);
      // $searchInput = $this->checkEmpty(['search' => $searchInput]);

      // turn user input to lower case
      $searchInput = strtolower($searchInput);

      // search on the database title column
      $searchedResults =  $this->blog->searchBlog($searchInput);

      // add author name to the blog posts
      $searchedResults = $this->appendAuthorToBlog($searchedResults);

      header("Location: /viewallposts");
      $this->view->render("viewallposts", ["blogs" => $searchedResults]);
    }
  }

  function sort() {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      $sortInput = $this->sanitizeInput($_POST["sort"]);

      // sort based on user input [asc, desc]
      $sortResult = $this->blog->sortBy($sortInput);

      // add author object to the blog 
      $sortResult = $this->appendAuthorToBlog($sortResult);

      $this->view->render("viewallposts", ["blogs" => $sortResult]);
    }
  }

  public function show($id) {
    // load the post data
    $blog = $this->blog->getTheBlog($id);

    // load author name
    $authorName = $this->getBlogAuthorName([$blog->user_id]);

    // Loop through allBlogs and match user_id with authorNames
    foreach ($blog as $b) {
      foreach ($authorName as $author) {
        if ($blog->user_id === $author->id) {
          // Add the matched author object to the current blog object
          $blog->author = $author;
          break; // Exit inner loop once match is found
        }
      }
    }

    // check if current user alredy liked the blogpost or not
    $checkLike = $this->hasAlreadyLiked($blog->id, $_SESSION['user']['id']);

    // set true or false based on the return of $checkLike
    $checkLike = $checkLike ? true : false;

    // load comments
    $comments = $this->loadComments($id);

    // load username for the comments
    $usernameForComments = $this->loadUsernameForComment($comments);

    // render specific blog view
    $this->view->render('blog', ['blog' => $blog, 'comments' => $usernameForComments, 'already_liked' => $checkLike]);
  }

  public function getBlogAuthorName($blog) {
    $authorNames = [];

    foreach ($blog as $value) {
      $authorNames[] = $this->blog->fetchAuthorName($value);
    }

    return $authorNames;
  }

  function hasAlreadyLiked($blog_id, $user_id) {
    return $this->blog->checkLiked($blog_id, $user_id);
  }

  public function loadComments($id) {
    return $this->blog->loadCommentForBlog($id);
  }

  public function loadUsernameForComment($comments) {
    $user = new User();
    $user_id = [];
    $username = [];

    // Get all the user IDs from comments
    foreach ($comments as $comment) {
      $user_id[] = $comment->user_id;
    }

    // Get usernames from DB & store them
    foreach ($user_id as $id) {
      $username[] = $user->getUser($id);
    }

    // Store both comments and usernames in an array of objects
    $combineCommentAndUsername = [];

    foreach ($comments as $comment) {
      foreach ($username as $user) {
        if ($user->id === $comment->user_id) {
          // Check if the comment with the current ID already exists in the array
          $exists = false;
          foreach ($combineCommentAndUsername as $existingEntry) {
            if ($existingEntry['comment']->id === $comment->id) {
              $exists = true;
              break;
            }
          }

          // If not exists, add the comment and user data to the array
          if (!$exists) {
            $combineCommentAndUsername[] = [
              'comment' => (object) $comment,
              'user' => (object) $user
            ];
          }
        }
      }
    }

    return $combineCommentAndUsername;
  }

  // here before adding to the $combineCommentAndUsername array check if array of array as comment key then in object check if the current id already in this $combineCommentAndUsername array or not. below  i am providing the method which perform the array adding and then i provide you array sample output 

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
    // register the like to the database
    $this->blog->registerLike($id, $_SESSION['user']['id']);

    // get the current like count from table with blog id
    $oldLikeCount = $this->getCountLike($id);

    $LikeCountIncrease = $oldLikeCount->like_count + 1;

    // increae the like count to blogs table
    $this->blog->likeCountIncreament($id, $LikeCountIncrease);
    header("Location:/blogs/show/$id");
  }

  function getCountLike($id) {
    return $this->blog->getLikeCountForTheBlog($id);
  }

  public function create() {
    // get category data from the DB
    $categories = $this->blog->getCategoryTitle();
    $this->view->render('dashboard', ['categories' => $categories]);
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
    $category = $this->sanitizeInput($_POST['category']);

    if (empty($title) || empty($description) || empty($tags)) {
      $errors['field_require'] = 'all the filelds must be filled';
    }

    // if error exist redirect to create-blog route again with error
    if (!empty($errors)) {
      header('Location: /blogs/create');
      $_SESSION['blog_create_err'] = $errors;
    } else {
      // no error generated
      $data =
        ['user_id' => $_SESSION['user']['id'], 'title' => $title, "description" => $description, "tags" => $tags, "created_at" => timestamp(), "category" => $category];

      // insert & success result store
      $this->blog->insertBlogData($data);

      header('Location: /blogs');
      unset($_SESSION['blog_create_err']);
    }
  }
}
