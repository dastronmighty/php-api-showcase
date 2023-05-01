<?php declare(strict_types=1);
// api/roter/routes/userroutes/putUserRoutes.php

function handleUpdateUser(array $params, Logger $logger, UserController $userController) : Response {
    $userId = intval($params['uid']);
    $logger->logEvent("PUT with id $userId");
    $data = json_decode(file_get_contents("php://input"), true);
    if (!empty($data)) {
        $result = $userController->updateUser($userId, $data);
        if ($result instanceof Response) {
            return $result;
        } else {
            if ($result) {
                $logger->logEvent("User $userId Updated");
                $response = new Response(200, ['HTTP/1.1 200 OK'], ["message" => "User updated successfully"]);
            } else {
                $response = ErrorHandler::create500Error("Failed to update user", "handleUpdateUser", $logger);
            }
        }
    } else {
        $response = ErrorHandler::create400Error("No data provided for update", "handleUpdateUser", $logger);
    }
    return $response;
}
?>