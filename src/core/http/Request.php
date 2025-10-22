<?php

namespace MyProject\core\http;

class Request {
    public string $method;
    public string $uri;
    public array $query;
    public array $body;
    public array $headers;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->query = $_GET;
        $this->headers = getallheaders();

        // Captura o corpo da requisição (JSON ou form)
        // Se for JSON, decodifica
        $rawBody = file_get_contents('php://input');
        $this->body = json_decode($rawBody, true) ?? $_POST;
    }

    public function input(string $key, $default = null) {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    public function header(string $key, $default = null) {
        return $this->headers[$key] ?? $default;
    }
}