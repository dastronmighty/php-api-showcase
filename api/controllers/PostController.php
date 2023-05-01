<?php declare(strict_types=1);
// api/controllers/PostController.php

include_once(__DIR__ . '/../models/PostModel.php');

class PostController {
  private $model;

  function __construct() {
    $this->model = new PostModel();
  }

  public function getPostById(int $userId) : string {
    return $this->model->getPostById($userId);
  }
}
?>