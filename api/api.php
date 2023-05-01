<?php declare(strict_types=1);
// api/api.php

include_once(__DIR__ . '/../config/DB.php');
include_once(__DIR__ . '/../logging/Logger.php');
include_once(__DIR__ . '/classes/Response.php');
include_once(__DIR__ . '/router/Router.php');
include_once(__DIR__ . '/router/routes/UserRoutes.php');
include_once(__DIR__ . '/router/routes/PostRoutes.php');

function handleRequest() {
    $router = new Router("api");

    registerUserRoutes($router);
    registerPostRoutes($router);

    $logger = new Logger("api.php");
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    $logger->logEvent("$requestMethod to $uri");
    $path = parse_url($uri, PHP_URL_PATH);

    $response = $router->handleRequest($requestMethod, $path);
    $response->send();
}
?>