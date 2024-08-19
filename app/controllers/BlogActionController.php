<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use App\Traits\BlogTraits;
use Core\Controller;
use App\Models\Blog;
use App\Models\Category;
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
  private $categories;
  private $defaultSort = 'asc';

  public function __construct() {
    $this->blog = new Blog();
    $category = new Category();

    $this->categories = $category->getCategoryTitles();
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

      // sanitize
      $this->sanitize($commentData);

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
    $this->blog->registerLike($id, $_SESSION['user'][0]->id);

    // get the current like count from table with blog id
    $oldLikeCount = $this->getCountLike($id);

    $LikeCountIncrease = $oldLikeCount[0]->like_count + 1;

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

      // header("Location: /viewallblogs");
      $this->view->render("viewallposts", ["blogs" => $searchedResults, 'categories' => $this->categories, 'sortBy' => $this->defaultSort]);
    }
  }

  function sort($id) {
    $sortInput = $id;

    $this->defaultSort = $id;

    // save the sorting option in settings session
    $_SESSION['settings']['sortBy'] = $sortInput;

    // sort based on user input [asc, desc]
    $sortResult = $this->blog->sortBy($sortInput);

    // cleanup uri
    $this->view->render("viewallblogs", ["blogs" => $sortResult, 'sortBy' => $sortInput, 'categories' => $this->categories]);
  }

  public function submitBlog($categoriesLists) {
    $errors = [];

    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $category = $_POST['category'];
    $cover_image = $_FILES['cover_image'];

    // sanitize
    $this->sanitize(['title' => $title, 'description' => $description, 'tags' => $tags, 'category' => $category,]);

    // handle file sanitize & upload
    $this->blog->handleFileUpload($cover_image, 'uploads/blogs/cover_images/');

    // check empty
    $requiredFields = ['title', 'description'];
    $emptyCheck = $this->isEmpty(['title' => $title, 'description' => $description,], $requiredFields);

    if (is_array($emptyCheck) && isset($emptyCheck[0])) {
      return $this->view->render('createBlog', ['errors' => $emptyCheck, 'categories' => $this->categories]);
    }

    // validate data
    $validationResult = $this->validateField(
      [
        'title' =>
        [
          'data' => $title,
          'validateMethod' => 'stringValidate',
          'rules' => ['min_length' => 5, 'max_length' => 30]
        ],
        'description' =>
        [
          'data' => $description,
          'validateMethod' => 'stringValidate',
          'rules' => ['min_length' => 10, 'max_length' => 100000]
        ],
      ]
    );

    if (is_array($validationResult) && isset($validationResult[0])) {
      return $this->view->render('createBlog', ['categories' => $this->categories, 'errors' => $validationResult, 'title' => $title, 'description' => $description, 'tags' => $tags]); // Return validation errors.
    } else {
      $data =
        ['user_id' => $_SESSION['user'][0]->id, 'title' => $title, "description" => $description, "tags" => $tags, "created_at" => timestamp(), "category" => $category, 'image' => $cover_image['name']];

      // insert data
      $this->blog->insertBlogData($data);
      header('location: /blogs');
    }
  }
}
