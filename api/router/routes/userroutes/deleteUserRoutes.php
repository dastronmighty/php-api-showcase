<?php declare(strict_types=1);
// api/roter/routes/userroutes/deleteUserRoutes.php

function handleDeleteUser(array $params, Logger $logger, UserController $userController) : Response {
    $userId = intval($params['uid']);
    $logger->logEvent("DELETE with id $userId");
    $result = $userController->deleteUser($userId);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['HTTP/1.1 200 OK'], ["message" => "User deleted successfully"]);
    }
    return $response;
}
?>