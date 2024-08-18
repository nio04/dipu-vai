<?php

namespace App\Controllers;

use App\Traits\ValidationTrait;
use App\Traits\BlogTraits;
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
  use BlogTraits;

  public $blog;
  public $blogAction;
  public $blogEdit;
  public $category;

  public function __construct() {
    $this->blog = new Blog();
    $this->blogAction = new BlogActionController();
    $this->category = new CategoryController();
    $this->blogEdit = new BlogEditController();
    parent::__construct();
  }

  // for dashboard
  public function viewAllBlogsAsAdmin() {
    $allBlogs = $this->blog->getAllBlogs();
    return $this->view->render('blogs', ['blogs' => $allBlogs]);
  }

  // not for dashboard
  public function viewallposts() {
    $allBlogs = $this->blog->getAllBlogs();

    // add author object to the blog object [append]
    $allBlogs = $this->appendAuthorToBlog($allBlogs,);

    $this->view->render('viewallposts', ['blogs' => $allBlogs]);
  }

  public function show($id) {

    // load the post data
    $blog = $this->blog->getTheBlog($id);

    // load author name
    $authorName = $this->getBlogAuthorName([$blog->user_id]);

    $blog->author = $authorName[0];

    // check if current user alredy liked the blogpost or not
    $checkLike = $this->blogAction->hasAlreadyLiked($blog->id, $_SESSION['user']['id'] ?? "");

    // set true or false based on the return of $checkLike
    $checkLike = $checkLike ? true : false;

    // load comments
    $comments = $this->blogAction->loadComments($id);

    // load username for the comments
    $usernameForComments = $this->blogAction->loadUsernameForComment($comments);

    // render specific blog view
    $this->view->render('blog', ['blog' => $blog, 'comments' => $usernameForComments, 'already_liked' => $checkLike]);
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
