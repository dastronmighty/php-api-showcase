<?php declare(strict_types=1);
// api/roter/routes/userroutes/getUserRoutes.php

include_once(__DIR__ . "/../../../controllers/UserController.php");
include_once(__DIR__ . "/../../../classes/Response.php");

function handleGetUserById(array $params, Logger $logger, UserController $userController) : Response {
    $userId = intval($params['param']);
    $logger->logEvent("GET with id $userId");
    $result = $userController->getUserByID($userId);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['Content-Type: application/json'], json_decode($result, true));
    }
    return $response;
}

function handleGetUserByUsername(array $params, Logger $logger, UserController $userController) : Response {
    $username = strval($params['param']);
    $logger->logEvent("GET with username $username");
    $result = $userController->getUserByUsername($username);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['Content-Type: application/json'], json_decode($result, true));
    }
    return $response;
}

function handleGetUserByEmail(array $params, Logger $logger, UserController $userController) : Response {
    $email = strval($params['param']);
    $logger->logEvent("GET with email $email");
    $result = $userController->getUserByEmail($email);
    if ($result instanceof Response) {
        return $result;
    } else {
        $response = new Response(200, ['Content-Type: application/json'], json_decode($result, true));
    }
    return $response;
}

function handleGetUserByStar(array $params, Logger $logger, UserController $userController) : Response {
    $param = $params['param'];
    if (is_numeric($param)) {
        return handleGetUserById($params, $logger, $userController);
    } elseif (filter_var($param, FILTER_VALIDATE_EMAIL)) {
        return handleGetUserByEmail($params, $logger, $userController);
    } else {
        return handleGetUserByUsername($params, $logger, $userController);
    }
}

function handleGetUserFollows(array $params, Logger $logger, UserController $userController) : Response {
    $logger->logEvent("Handling Get User Follows");
    $userId = intval($params['uid']);
    return new Response(200, ['Content-Type: application/json'], ["user"=>["userid"=>"$userId"] ,"reponse"=>"true"]); // Cast $result to array
}

function handleGetUserLikes(array $params, Logger $logger, UserController $userController) : Response {
    $logger->logEvent("Handling Get User Likes");
    $userId = intval($params['uid']);
    return new Response(200, ['Content-Type: application/json'], ["user"=>["userid"=>"$userId"] ,"reponse"=>"true"]); // Cast $result to array
}

function handleGetUserPosts(array $params, Logger $logger, UserController $userController) : Response {
    $logger->logEvent("Handling Get User Posts");
    $userId = intval($params['uid']);
    return new Response(200, ['Content-Type: application/json'], ["user"=>["userid"=>"$userId"] ,"reponse"=>"true"]); // Cast $result to array
}

function handleGetUserComments(array $params, Logger $logger, UserController $userController) : Response {
    $logger->logEvent("Handling Get User Comments");
    $userId = intval($params['uid']);
    return new Response(200, ['Content-Type: application/json'], ["user"=>["userid"=>"$userId"] ,"reponse"=>"true"]); // Cast $result to array
}

?>