<?php declare(strict_types=1);
// api/roter/routes/UserRoutes.php

include_once(__DIR__ . '/../../controllers/UserController.php');
include_once(__DIR__ . '/../../classes/Response.php');
include_once(__DIR__ . '/../Router.php');
include(__DIR__ . '/userroutes/getUserRoutes.php');
include(__DIR__ . '/userroutes/postUserRoutes.php');
include(__DIR__ . '/userroutes/putUserRoutes.php');
include(__DIR__ . '/userroutes/deleteUserRoutes.php');

function createUserController(): UserController {
    static $userController;
    if ($userController === null) {
        $userController = new UserController();
    }
    return $userController;
}

function registerUserRoutes(Router &$router) : void {
    $logger = new Logger("UserRoutes.php");
    $userController = createUserController();
    $router->addRoute('GET', "users/:uid", function (array $params) use ($logger, $userController) {
        return handleGetUserById($params, $logger, $userController);
    });
    $router->addRoute('POST', "users", function () use ($logger, $userController) {
        return handleCreateUser($logger, $userController);
    });
    $router->addRoute('PUT', "users/:uid", function (array $params) use ($logger, $userController) {
        return handleUpdateUser($params, $logger, $userController);
    });
    $router->addRoute('DELETE', "users/:uid", function (array $params) use ($logger, $userController) {
        return handleDeleteUser($params, $logger, $userController);
    });
}
?>