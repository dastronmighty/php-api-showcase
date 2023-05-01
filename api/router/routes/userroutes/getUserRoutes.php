<?php declare(strict_types=1);
// api/roter/routes/userroutes/getUserRoutes.php

function handleGetUserById(array $params, Logger $logger, UserController $userController) : Response {
    $userId = intval($params['uid']);
    $logger->logEvent("GET with id $userId");
    $result = $userController->getUserByID($userId);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['Content-Type: application/json'], json_decode($result, true));
    }
    return $response;
}
?>