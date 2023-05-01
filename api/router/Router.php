<?php declare(strict_types=1);
// api/router/Router.php

include_once(__DIR__ . '/../../logging/Logger.php');
include_once(__DIR__ . '/../classes/Response.php');

class Router {
    private array $getRoutes = [];
    private array $postRoutes = [];
    private array $putRoutes = [];
    private array $deleteRoutes = [];
    private string $basePath;
    private Logger $logger;

    function __construct(string $basePath) {
        $this->basePath = $basePath;
        $this->logger = new Logger("Router.php");
    }

    private function getHandlerInfo(callable $handler): string {
        if ($handler instanceof Closure) {
            $reflection = new ReflectionFunction($handler);
            $file = basename($reflection->getFileName());
            $startLine = $reflection->getStartLine();
            $endLine = $reflection->getEndLine();
            return "Closure in $file from line $startLine to line $endLine";
        }
        return 'Unknown handler';
    }

    private function addGetRoute(string $pattern, callable $handler) : void {
        $this->getRoutes["/$this->basePath/$pattern"] = $handler;
    }

    private function addPostRoute(string $pattern, callable $handler) : void {
        $this->postRoutes["/$this->basePath/$pattern"] = $handler;
    }

    private function addPutRoute(string $pattern, callable $handler) : void {
        $this->putRoutes["/$this->basePath/$pattern"] = $handler;
    }

    private function addDeleteRoute(string $pattern, callable $handler) : void {
        $this->deleteRoutes["/$this->basePath/$pattern"] = $handler;
    }

    public function addRoute (string $method, string $pattern, callable $handler) : void {
        $handlerInfo = $this->getHandlerInfo($handler);
        $this->logger->logEvent("Creating $method Route $this->basePath/$pattern with handler $handlerInfo");
        switch ($method) {
            case 'GET':
                $this->addGetRoute($pattern, $handler);
                break;
            case 'POST':
                $this->addPostRoute($pattern, $handler);
                break;
            case 'PUT':
                $this->addPutRoute($pattern, $handler);
                break;
            case 'DELETE':
                $this->addDeleteRoute($pattern, $handler);
                break;
        }
    }


    public function handleRequest(string $method, string $path) : Response {
        $routesForMethod = match($method) {
            'GET' => $this->getRoutes,
            'POST' => $this->postRoutes,
            'PUT' => $this->putRoutes,
            'DELETE' => $this->deleteRoutes,
            default => []
        };
        $routesForMethodJson = json_encode($routesForMethod);
        $this->logger->logEvent("Routes for method $routesForMethodJson");
        $this->logger->logEvent("Handle $method on $path");
        foreach ($routesForMethod as $pattern => $handler) {
            $params = []; // Initialize the $params variable as an empty array
            if ($this->matchPattern($pattern, $path, $params)) {
                $paramsStr = json_encode($params);
                $this->logger->logEvent("Params found $paramsStr");
                return $handler($params);
            }
        }
        // No matching route found, return a 404 response
        return new Response(404, ['Content-Type: application/json'], ["error" => "$path Not found"]);
    }

    private function matchPattern(string $pattern, string $path, array &$params) : bool {
        $replace_pattern = '#:([\w]+)#';
        $replace = '(?P<$1>[\w-]+)';
        $this->logger->logEvent("find pattern $replace_pattern in $pattern and replace with $replace");
        $pattern = preg_replace($replace_pattern, $replace, $pattern);
        $pattern = "#^$pattern$#";
        $this->logger->logEvent("New Pattern is $pattern");
        if (preg_match($pattern, $path, $matches)) {
            $this->logger->logEvent("$path -> $pattern matches");
            foreach ($matches as $key => $match) {
                if (is_string($key)) {
                    $params[$key] = $match;
                }
            }
            return true;
        }
        return false;
    }
}
?>