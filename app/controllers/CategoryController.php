<?php

namespace App\Controllers;

use App\Models\Category;
use App\Traits\ValidationTrait;
use Core\Controller;
use App\Models\Blog;


class CategoryController extends Controller {
  use ValidationTrait;

  private $blog;
  private $category;
  private $categories;

  public function __construct() {

    $this->blog = new Blog();
    $this->category = new Category();

    $this->categories = $this->load();

    parent::__construct();
  }

  function index() {

    $this->view->render('category', ['categories' => $this->categories]);
  }

  function load() {
    // get all the category titles
    return $this->category->getCategoryTitles();
  }

  function create() {
    $this->view->render("createCategory");
  }

  function edit($id) {
    // get data from DB with ID
    $categoryDetail = $this->category->getCategoryDetail($id);

    $this->view->render("editCategory", ["category" => $categoryDetail]);
  }

  function delete($id) {
    $this->category->deleteCategory($id);
    header("Location: /category");
  }

  function submit() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // check category edit or delete
      $categoryStatus = $_POST['category_status'];
      $id = $categoryStatus === "edit" ? $_POST['id'] : "";
      $title = isset($_POST['title']) ? $_POST['title'] : "";

      // sanitize
      $title = $_POST['title'];
      // check if field empty
      $title = $this->sanitize($title);

      // set empty field error
      $emptyCheck = $this->isEmpty(['title' => $title], ['title']);

      if (is_array($emptyCheck) && isset($emptyCheck[0])) {
        return $this->view->render('createCategory', ['errors' => $emptyCheck]);
      }

      $checkIfAlreadyExist = $this->category->checkExistCategory($title);

      if ($checkIfAlreadyExist) {
        return $this->view->render('createCategory', ['errors' => ['category title already found. can not use this title again'], 'category' => $title]);
      } else {
        $this->category->insertCategory($title);
        header("Location: /category");
      }
    }
  }
}
