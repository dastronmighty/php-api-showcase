<?php declare(strict_types=1);
// api/roter/routes/postroutes/getPostRoutes.php

include_once(__DIR__ . "/../../../controllers/PostController.php");
include_once(__DIR__ . "/../../../classes/Response.php");

function handleGetPostById(array $params, Logger $logger, PostController $postController) : Response {
    $userId = intval($params['pid']);
    $logger->logEvent("GET post with id $userId");
    $result = $postController->getPostById($userId);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['Content-Type: application/json'], json_decode($result, true));
    }
    return $response;
}

?>