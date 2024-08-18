<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use App\Traits\BlogTraits;
use Core\Controller;
use App\Models\Blog;
use App\Models\User;

/**
 * This controller control action for
 * like, comment, sort, search
 * and handle submitBlog action
 */
class BlogActionController extends Controller {
  use ValidationTrait;
  use BlogTraits;

  public $blog;
  public function __construct() {
    $this->blog = new Blog();
    parent::__construct();
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
      $commentData = $_POST['comment'];
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

  function search() {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      // sanitize
      $searchInput = $_POST['search'];
      // $searchInput = $this->checkEmpty(['search' => $searchInput]);


      // turn user input to lower case
      $searchInput = strtolower($searchInput);

      // search on the database title column
      $searchedResults =  $this->blog->searchBlog($searchInput);

      // add author name to the blog posts
      $searchedResults = $this->appendAuthorToBlog($searchedResults);

      // header("Location: /viewallposts");
      $this->view->render("viewallposts", ["blogs" => $searchedResults]);
    }
  }

  function sort($id) {
    $sortInput = $id;

    // save the sorting option in settings session
    $_SESSION['settings']['sortBy'] = $sortInput;

    // sort based on user input [asc, desc]
    $sortResult = $this->blog->sortBy($sortInput);

    // add author object to the blog 
    $sortResult = $this->appendAuthorToBlog($sortResult);

    // cleanup uri
    $this->view->render("viewallposts", ["blogs" => $sortResult]);
  }

  public function submitBlog($categoriesLists) {
    $errors = [];

    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];
    $cover_image = $_FILES['cover_image'];
    /**
     * @var bool 
     * true: means image file processing error
     * false: means image file processing NOT error 
     */
    $image_error = true;

    // sanitize file name
    $fileName = basename($cover_image['name']);

    $targetDir = basePath('uploads/blogs/cover_images/');
    $targetFile = $targetDir . $fileName;

    // check type extension
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedType = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileType, $allowedType)) {
      // move file to the target directory
      if (move_uploaded_file($cover_image['tmp_name'], $targetFile)) {
        // insert to DB
        $image_error = false;
      }
    }

    if (empty($title) || empty($description) || empty($tags) || $image_error === true) {
      $errors['field_require'] = 'all the filelds must be filled or something else wrong';
    }

    // if error exist redirect to create-blog route again with error
    if (!empty($errors)) {
      return $this->view->render("createBlog", ["errors" => $errors, 'categories' => $categoriesLists]);
      // header('Location: /blogs/create');
      // $_SESSION['blog_create_err'] = $errors;
    } else {
      // no error generated
      $data =
        ['user_id' => $_SESSION['user']['id'], 'title' => $title, "description" => $description, "tags" => $tags, "created_at" => timestamp(), "category" => $category, 'image' => $fileName];

      // insert & success result store
      $this->blog->insertBlogData($data);

      header('Location: /blogs');
      // unset($_SESSION['blog_create_err']);
    }
  }
}
