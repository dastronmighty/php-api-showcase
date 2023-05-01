<?php declare(strict_types=1);
// api/classes/Post.php

include_once(__DIR__ . '/../../logging/Logger.php');

class Post {
    private int $id;
    private string $title;
    private string $body;
    private int $updated_times;
    private string $updated_at;
    private int $user_id;
    private string $created_at;

    private Logger $logger;

    function __construct(int $id, 
                        string $title,
                        string $body,
                        int $updated_times, 
                        string $updated_at,
                        int $user_id,
                        string $created_at) {     
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->updated_times = $updated_times;
        $this->updated_at = $updated_at;
        $this->user_id = $user_id;  
        $this->created_at = $created_at;
        $this->logger = new Logger("Post.php");
        $this->logger->logEvent("New Post Class with ID = $this->id");
    }

    function getPostDetails() : array {
        try {
            $user_details_array = array('id'=>$this->id,
                                        'title' => $this->title, 
                                        'body' => $this->body,
                                        'updated_times' => $this->updated_times,
                                        'updated_at' => $this->updated_at,
                                        'user_id' => $this->user_id,
                                        'created_at' => $this->created_at);
            return $user_details_array;
        } catch (Exception $e) {
            $this->logger->logEvent("Failed to get details: $e");
            return array();
        }
    }

    function getPostDetailsJSON() : string {
        $this->logger->logEvent("Getting Post $this->id details as json");
        return json_encode($this->getPostDetails());
    }
}
?>