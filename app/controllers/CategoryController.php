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

  public function __construct() {
    $this->blog = new Blog();
    $this->category = new Category();
    parent::__construct();
  }

  function index() {
    $categories =  $this->loadCategories();
    $this->view->render('dashboard', ['categories' => $categories]);
  }

  function loadCategories() {
    // get all the category titles
    return $this->category->getCategoryTitles();
  }

  function createCategory() {
    $this->view->render("dashboard");
  }

  function edit($id) {
    // get data from DB with ID
    $categoryDetail = $this->category->getCategoryDetail($id);

    $this->view->render("dashboard", ["category" => $categoryDetail]);
  }

  function delete($id) {
    $this->category->deleteCategory($id);
    header("Location: /category");
  }

  function submitCategory() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $errors = [];

      // sanitize
      $categoryTitle = $this->sanitizeInput($_POST['title']);
      // check if field empty
      $categoryTitle = $this->checkEmpty([$categoryTitle]);

      // set empty field error
      if (count($categoryTitle) < 1) {
        $errors['category_empty_error'] = 'category field can not be empty';
      }

      // check if current category exist already
      $ifExistCategory = $this->category->checkExistCategory(implode($categoryTitle));
      if ($ifExistCategory) {
        $errors['category_exist_error'] = 'current category already found. it can not be used again';
      } else {
        $this->category->insertCategory(implode($categoryTitle));
      }

      if (empty($errors)) {
        unset($_SESSION['errors']);
        header('Location: /category');
      } else {
        $_SESSION['errors'] = $errors;
        header("Location:/category/createCategory");
        $this->view->render("dashboard");
      }
    }
  }
}
