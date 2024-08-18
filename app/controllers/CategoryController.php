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
    $categories =  $this->load();
    $this->view->render('category', ['categories' => $categories]);
  }

  function load() {
    // get all the category titles
    return $this->category->getCategoryTitles();
  }

  function create() {
    $this->view->render("createCategory", ["category" => ""]);
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

      $errors = [];

      // sanitize
      $title = $this->sanitizeInput($_POST['title']);
      // check if field empty
      $title = $this->checkEmpty([$title]);

      // set empty field error
      if (count($title) < 1) {
        $errors['category_empty_error'] = 'category field can not be empty';
        return $this->view->render('createCategory', ['errors' => $errors]);
      }
      // check if current category exist already
      $ifExistCategory = $this->category->checkExistCategory(implode($title));

      if ($ifExistCategory) {
        $errors['category_exist_error'] = 'current category already found. it can not be used again';
        // $title['category'] = $title[0];
        // echo ("<pre>");
        // var_dump(['errors' => $errors, 'category' => $title[0]]);
        // echo ("</pre>");
        return $this->view->render('createCategory', ['errors' => $errors, 'category' => $title[0]]);
      }

      // check category create or edit
      if ($categoryStatus === "create") {
        $this->category->insertCategory(implode($title));
      } else {
        // category edit
        $this->category->edit($id, $title);
      }


      if (empty($errors)) {
        // unset($_SESSION['errors']);
        header('Location: /category');
      } else {
        // $_SESSION['errors'] = $errors;
        // header("Location:/category/edit");
        // $this->view->render("dashboard");
      }
    }
  }
}
