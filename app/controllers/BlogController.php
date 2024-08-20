<?php

namespace App\Controllers;

use App\Traits\DatabaseTrait;
use App\Traits\SessionTrait;
use App\Traits\ValidationTrait;
use Core\Controller;
use App\Models\Blog;
use App\Controllers\CategoryController;
use App\Controllers\BlogActionController;
use App\Controllers\BlogEditController;

/**
 * for now, this BlogController class will dispatch other controller file
 * for example: BlogActionController, BlogEditController
 */

class BlogController extends Controller {
  use ValidationTrait;
  use DatabaseTrait;
  use SessionTrait;

  public $blog;
  public $blogAction;
  public $blogEdit;
  public $category;
  public $categoriesList;
  private $defaultSort = 'asc';

  public function __construct() {
    $this->blog = new Blog();
    $this->blogAction = new BlogActionController();
    $this->category = new CategoryController();
    $this->blogEdit = new BlogEditController();
    $this->categoriesList = $this->category->load();
    $this->connect();
    parent::__construct();
  }

  // for dashboard
  public function viewAllBlogsAsAdmin() {
    $allBlogs = $this->blog->getAllBlogs();
    return $this->view->render('blogs', ['blogs' => $allBlogs, 'categories' => $this->categoriesList, 'sortBy' => $this->defaultSort, 'username' => $this->username, 'isAdmin' => $this->isAdmin, 'isLoggedIn' => $this->isLoggedIn, 'showUserName' => $this->showUserName]);
  }

  // not for dashboard
  public function viewallblogs() {
    $allBlogs = $this->blog->getAllBlogs();

    $this->defaultSort = $this->getSession(['settings', 'sortBy']);

    $this->view->render('viewallblogs', ['blogs' => $allBlogs, 'categories' => $this->categoriesList, 'sortBy' => $this->defaultSort, 'username' => $this->username, 'isAdmin' => $this->isAdmin, 'isLoggedIn' => $this->isLoggedIn]);
  }

  public function show($id) {
    // load blog & author data and join it together
    $blogAndAuthor =  $this->joinQuery([
      'tables' => ['blogs', 'users'],
      'joinConditions' => [
        'blogs.user_id = users.id',
      ],
      'selectColumns' => [
        'blogs.*',
        'users.username',
        'users.email',
      ],
      'whereConditions' => [
        "blogs.id = $id",
      ]
    ]);

    $commentsAndAuthor =
      $this->joinQuery([
        'tables' => ['comments', 'users'],
        'joinConditions' => [
          'comments.user_id = users.id',
        ],
        'selectColumns' => [
          'comments.*',
          'users.username',
        ],
        'whereConditions' => [
          "comments.blog_id = $id",
        ]
      ]);

    // check if current user alredy liked the blogpost or not
    // $checkLike = $this->blogAction->hasAlreadyLiked($blogAndAuthor[0]->id, $_SESSION['user'][0]->id ?? "");
    $checkLike = $this->blogAction->hasAlreadyLiked($blogAndAuthor[0]->id, $this->getSession(['user', 'id']));

    // set true or false based on the return of $checkLike
    $checkLike = $checkLike ? true : false;

    // render specific blog view
    $this->view->render('blog', ['blog' => $blogAndAuthor[0], 'comments' => isset($commentsAndAuthor[0]) ? $commentsAndAuthor : [], 'already_liked' => $checkLike]);
  }

  /**
   * all the BlogActionController start here 
   * search, sort, like, createComment, 
   */

  function search() {
    $this->blogAction->search();
  }

  function sort($id) {
    $this->blogAction->sort($id);
  }

  function like($id) {
    $this->blogAction->like($id);
  }

  function createComment($id) {
    $this->blogAction->createComment($id);
  }

  /** 
   * all the BlogEditController start here 
   * create, edit, update, delete, submit
   */

  function create() {
    $this->blogEdit->create();
  }

  function edit($id) {
    $this->blogEdit->edit($id);
  }

  function update() {
    $this->blogEdit->update();
  }

  function delete($id) {
    $this->blogEdit->delete($id);
  }

  function submit() {
    $this->blogEdit->submit();
  }
}
