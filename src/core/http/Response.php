<?php

namespace MyProject\core\http;

class Response {
    public static function json($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public static function text(string $content, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: text/plain');
        echo $content;
    }

    public static function html(string $html, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: text/html');
        echo $html;
    }

    public static function redirect(string $url, int $status = 302): void {
        http_response_code($status);
        header("Location: $url");
        exit;
    }
}