<?php declare(strict_types=1);
// api/controllers/UserController.php

include_once(__DIR__ . '/../models/UserModel.php');

class UserController {
  private $model;

  function __construct() {
    $this->model = new UserModel();
  }

  public function getUserByID(int $userId) : string {
    return $this->model->getUserById($userId);
  }

  public function getUserByUsername(string $username) : string {
    return $this->model->getUserByUsername($username);
  }

  public function getUserByEmail(string $email) : string {
    return $this->model->getUserByEmail($email);
  }

  public function createUser(string $username,
                            string $email,
                            string $password,
                            string $first_name, 
                            string $last_name) : int {
    return $this->model->createUser($username, 
                                    $email,
                                    $password,
                                    $first_name, 
                                    $last_name);
  }

  public function updateUser(int $userId, array $data) : bool {
      return $this->model->updateUser($userId, $data);
  }

  public function deleteUser(int $userId) : bool {
    return $this->model->deleteUser($userId);
  }
}
?>