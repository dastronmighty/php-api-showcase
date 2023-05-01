<?php declare(strict_types=1);
// api/roter/routes/PostRoutes.php

include_once(__DIR__ . '/../../controllers/PostController.php');
include_once(__DIR__ . '/../../classes/Response.php');
include_once(__DIR__ . '/../Router.php');
include_once(__DIR__ . '/postroutes/getPostRoutes.php');

function createPostController(): PostController {
    static $postController;
    if ($postController === null) {
        $postController = new PostController();
    }
    return $postController;
}

function registerPostRoutes(Router &$router) : void {
    $logger = new Logger("PostRoutes.php");
    $postController = createPostController();
    $router->addRoute('GET', "posts/:pid", function (array $params) use ($logger, $postController) {
        return handleGetPostById($params, $logger, $postController);
    });
}
?>