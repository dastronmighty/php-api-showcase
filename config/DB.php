<?php declare(strict_types=1);
// config/DB.php

include_once(__DIR__ . '/../logging/Logger.php');

class Database {
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $db;
    private Logger $logger;

    function __construct(string $database_name) {
        $this->logger = new Logger("DB.php");
        $this->db = $database_name;
        $this->logger->logEvent("New database created: " . $database_name);
    }

    private function getConnection() : PDO {
        $connect_string = "mysql:host=".$this->servername.";dbname=".$this->db;
        try {
            $conn = new PDO($connect_string, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            $this->logger->logEvent("Successfully connected to the database");
        }  catch (PDOException $e) {
            $this->logger->logEvent("Connection failed: " . $e->getMessage());
            return null;
        }
    }

    function queryDatabase(string $query, array $params = []) : PDOStatement
    {
        $this->logger->logEvent("Querying DB: ".$query);
        $conn = $this->getConnection();
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $this->logger->logEvent("Query succeeded: ".$query);
            $conn = null; // Close the connection
            return $stmt;
        } catch (PDOException $e) {
            $this->logger->logEvent("Query failed: " . $e->getMessage());
            $conn = null; // Close the connection
            return null;
        }  
    }
}

?>