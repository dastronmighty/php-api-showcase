<?php declare(strict_types=1);
// api/models/UserModel.php

include_once(__DIR__ . '/../classes/User.php');
include_once(__DIR__ . '/../../config/DB.php');
include_once(__DIR__ . '/../../logging/Logger.php');
include_once(__DIR__ . '/../classes/ErrorHandler.php');

class UserModel {
    private Database $db;
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger("UserModel.php");
        $this->db = new Database("test_api");
    }

    public function getUserById(int $userId) : string {
        $this->logger->logEvent("Getting User : $userId");
        $sql = "SELECT * FROM users WHERE id = ?";
        $params = [$userId];
        try {
            $result = $this->db->queryDatabase($sql, $params);
            if ($result) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $user = new User($row['id'], 
                                $row['username'], 
                                $row['email'], 
                                $row['first_name'], 
                                $row['last_name'], 
                                $row['created_at']);
                return $user->getUserDetailsJSON();
            } else {
                return json_encode((object)[]);
            }
        } catch (PDOException $e) {
            $response = ErrorHandler::handlePDOError($e, $this->logger);
            return $response;
        }
    }

    public function createUser(string $username,
                               string $email,
                               string $password,
                               string $first_name, 
                               string $last_name) : int {
        $this->logger->logEvent("Creating new users");
        $insert_vals = "username, email, password, first_name, last_name";
        $sql = "INSERT INTO users ($insert_vals) VALUES (?, ?, ?, ?, ?);";
        $params = [$username, $email, $password, $first_name, $last_name];
        try {
            $result = $this->db->queryDatabase($sql, $params);
            $affectedRows = $result->rowCount();
            $this->logger->logEvent("User Created");
            $result = null; 
            return $affectedRows;
        } catch (PDOException $e) {
            $response = ErrorHandler::handlePDOError($e, $this->logger);
            return $response;
        }
    }

    public function updateUser(int $userId, array $data) : bool {
        $setValues = '';
        $params = [];
    
        foreach ($data as $key => $value) {
            $setValues .= $key . " = ?, ";
            $params[] = $value;
        }
        $setValues = rtrim($setValues, ', ');
        $params[] = $userId;
    
        $sql = "UPDATE users SET $setValues WHERE id = ?";
    
        try {
            $result = $this->db->queryDatabase($sql, $params);
            $affectedRows = $result->rowCount();
            $result = null;
            return $affectedRows > 0;
        } catch (PDOException $e) {
            $response = ErrorHandler::handlePDOError($e, $this->logger);
            return $response;
        }
    }    

    public function deleteUser(int $userId) : bool {
        $this->logger->logEvent("Deleting User : $userId");
        $sql = "DELETE FROM users WHERE id = ?";
        $params = [$userId];

        try {
            $result = $this->db->queryDatabase($sql, $params);
            $affectedRows = $result->rowCount();
            $result = null;
            return $affectedRows > 0;
        } catch (PDOException $e) {
            $response = ErrorHandler::handlePDOError($e, $this->logger);
            return $response;
        }
    }
}
?>