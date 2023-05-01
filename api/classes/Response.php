<?php declare(strict_types=1);
// api/classes/Response.php

class Response {
    private int $code;
    private array $headers;
    private array $body;

    public function __construct(int $code, array $headers = [], array $body = []) {
        $this->code = $code;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function setCode(int $code) {
        $this->code = $code;
    }

    public function addHeader(string $header) {
        $this->headers[] = $header;
    }

    public function setBody(array $body) {
        $this->body = $body;
    }

    public function setError(int $code, string $message) {
        $this->code = $code;
        $this->body = ['error' => $message];
    }

    public function send() {
        http_response_code($this->code);
        foreach ($this->headers as $header) {
            header($header);
        }
        echo json_encode($this->body);
    }
}
?>