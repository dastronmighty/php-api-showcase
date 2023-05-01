<?php declare(strict_types=1); // strict requirement
// logging/Logger.php

$logFile = __DIR__ . '/api.log';

class Logger {
    private string $logger_name;

    function __construct(string $logger_name) {
        $this->logger_name = $logger_name;
    }

    // Function to log events
    function logEvent(string $message) : void {
        global $logFile;
        $timestamp = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $logMessage = "[$timestamp] - $ip_address - $user_agent - ($this->logger_name) MESSAGE: $message\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}

?>