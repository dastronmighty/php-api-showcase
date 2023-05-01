<?php declare(strict_types=1);
// api/roter/routes/userroutes/postUserRoutes.php

function handleCreateUser(Logger $logger, UserController $userController) : Response {
    // Extract the JSON payload from the request
    $data = json_decode(file_get_contents("php://input"), true);
    // Ensure the required fields are present
    if (isset($data['username']) && isset($data['email']) &&
        isset($data['password']) && isset($data['first_name']) &&
        isset($data['last_name'])) {
        $result = $userController->createUser($data['username'], 
                                                $data['email'], 
                                                $data['password'], 
                                                $data['first_name'], 
                                                $data['last_name']);
        if ($result instanceof Response) {
            return $result;
        } else {
            if ($result != 0) {
                $logger->logEvent("New User created");
                $response = new Response(201, ['HTTP/1.1 201 Created'], ["message" => "User created successfully"]);
            } else {
                $response = ErrorHandler::create500Error("Failed to create user", "handleCreateUser", $logger);
            }
        }
    } else {
        $logger->logEvent("New User Bad Request. Missing Fields");
        $response = new Response(400, ['HTTP/1.1 400 Bad Request'], ["error" => "Required fields missing"]);
    }
    return $response;
}
?>