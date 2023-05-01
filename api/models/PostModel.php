<?php declare(strict_types=1);
// api/classes/Post.php

include_once(__DIR__ . '/../classes/Post.php');
include_once(__DIR__ . '/../../config/DB.php');
include_once(__DIR__ . '/../../logging/Logger.php');
include_once(__DIR__ . '/../classes/ErrorHandler.php');

class PostModel {
    private Database $db;
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger("PostModel.php");
        $this->db = new Database("test_api");
    }

    public function getPostById(int $postId) : string {
        $this->logger->logEvent("Getting Post : $postId");
        $sql = "SELECT * FROM posts WHERE id = ?";
        $params = [$postId];
        try {
            $result = $this->db->queryDatabase($sql, $params);
            if ($result) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $post = new Post($row['id'], 
                                $row['title'], 
                                $row['body'], 
                                $row['updated_times'], 
                                $row['updated_at'], 
                                $row['user_id'],
                                $row['created_at']);
                return $post->getPostDetailsJSON();
            } else {
                return json_encode((object)[]);
            }
        } catch (PDOException $e) {
            $response = ErrorHandler::handlePDOError($e, $this->logger);
            return $response;
        }
    }

}

?>