<?php
class ErrorHandler {
    public static function handlePDOError(PDOException $e, Logger $logger) : Response {
        $response = new Response(500);
        $response->setError(500, "Internal Server Error");

        switch ($e->getCode()) {
            case 23000: // Duplicate entry
                $response->setError(409, "Conflict: Duplicate entry");
                break;
            case 1048: // Column cannot be null
                $response->setError(400, "Bad Request: Required field(s) missing");
                break;
            case 1054: // Unknown column
                $response->setError(400, "Bad Request: Invalid field(s) specified");
                break;
            case 1062: // Unique constraint violation
                $response->setError(409, "Conflict: Unique constraint violation");
                break;
            case 1451: // Foreign key constraint violation
                $response->setError(409, "Conflict: Foreign key constraint violation");
                break;
            case 1452: // Foreign key constraint violation - Cannot add or update a child row
                $response->setError(409, "Conflict: Cannot add or update a child row");
                break;
            case 42000: // Syntax error or access violation
                $response->setError(400, "Bad Request: Syntax error or access violation");
                break;
            default:
                $response->setError(500, "Internal Server Error: An unexpected error occurred");
            // TODO: Add more cases for different error codes as needed
        }

        $logger->logEvent("Error: " . $e->getMessage());

        return $response;
    }

    private static function createErrorResponse(int $statusCode, 
                                string $header,
                                string $errorMessage,
                                string $functionName,
                                Logger $logger) : Response {
        $logger->logEvent("Error: $functionName $statusCode: $errorMessage");
        return new Response($statusCode, ['Content-Type: application/json', $header], ["error" => $errorMessage]);
    }

    public static function create400Error(string $errorMessage,
                                        string $functionName,
                                        Logger $logger) : Response {
        return self::createErrorResponse(400,
                                    'HTTP/1.1 400 Bad Request',
                                    $errorMessage, 
                                    $functionName, 
                                    $logger);
    }
    public static function create404Error(string $errorMessage,
                                          string $functionName,
                                          Logger $logger) : Response {
        return self::createErrorResponse(404,
                                         'HTTP/1.1 404 Not Found',
                                         $errorMessage, 
                                         $functionName, 
                                         $logger);
    }

    public static function create405Error(string $errorMessage,
                                          string $functionName,
                                          Logger $logger) : Response {
        return self::createErrorResponse(405,
                                         'HTTP/1.1 405 Method Not Allowed',
                                         $errorMessage, 
                                         $functionName, 
                                         $logger);
    }

    public static function create500Error(string $errorMessage,
                                          string $functionName,
                                          Logger $logger) : Response {
        return self::createErrorResponse(500,
                                         'HTTP/1.1 500 Internal Server Error',
                                         $errorMessage, 
                                         $functionName, 
                                         $logger);
    }
}

?>