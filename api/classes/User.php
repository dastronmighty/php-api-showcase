<?php declare(strict_types=1);
// api/classes/User.php

include_once(__DIR__ . '/../../logging/Logger.php');

class User {
    private int $id;
    private string $username;
    private string $email;
    private string $first_name;
    private string $last_name;
    private string $created_at;

    private Logger $logger;

    function __construct(int $id, 
                        string $username,
                        string $email,
                        string $first_name, 
                        string $last_name,
                        string $created_at) {     
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->created_at = $created_at;  
        $this->logger = new Logger("User.php");
        $this->logger->logEvent("New User Class with ID = $this->id");
    }

    function getUserDetails() : array {
        $this->logger->logEvent("Getting user $this->id details");
        try {
            $user_details_array = array('id'=>$this->id,
                                        'username' => $this->username, 
                                        'email' => $this->email,
                                        'first_name' => $this->first_name,
                                        'last_name' => $this->last_name,
                                        'created_at' => $this->created_at);
            return $user_details_array;
        } catch (Exception $e) {
            $this->logger->logEvent("Failed to get details: $e");
            return array();
        }
    }

    function getUserDetailsJSON() : string {
        $this->logger->logEvent("Getting user $this->id details as json");
        return json_encode($this->getUserDetails());
    }
}
?>