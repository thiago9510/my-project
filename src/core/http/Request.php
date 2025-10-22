<?php

namespace MyProject\core\http;

class Request {
    public string $method;
    public string $uri;
    public array $query;
    public array $body;
    public array $headers;
    public array $params = [];

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->query = $_GET;
        $this->headers = getallheaders();

        // Captura o corpo da requisição (JSON ou form)
        $rawBody = file_get_contents('php://input');
        $decoded =  json_decode($rawBody, true);
        $this->body = is_array($decoded) ? $decoded : $_POST;
    }

    /**
     * Verifica se o método HTTP da requisição corresponde ao esperado.
     *
     * @param string $expected O método HTTP esperado (ex: 'GET', 'POST', 'PUT', 'DELETE').
     * @return bool Retorna true se o método atual for igual ao esperado (case-insensitive), false caso contrário.
     */
    public function methodIs(string $expected): bool {
        return strtoupper($this->method) === strtoupper($expected);
    }
    /**
     * Retorna o metodo da Requisição
     */
    public function method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }   

    /**
     * Retorna um valor do corpo ou da query string
    */
    public function input(string $key, $default = null) {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    /**
     * Retorna um cabeçalho específico
    */
    public function header(string $key, $default = null) {
        return $this->headers[$key] ?? $default;
    }

    /**
     * Define os parâmetros capturados da rota (ex: /persons/{id})
     * para isar o param é necessário instanciar o setParams para capturar os parametros da rota
    */
    public function setParams(array $params): void {
        $this->params = $params;
    }

    /**
     * Retorna um parâmetro da rota
    */
    public function param(string $key, $default = null) {
        return $this->params[$key] ?? $default;
    }

    /**
     * Extrair o query parameters
    */
    public function query(string $key, $default = null) {
        return $this->query[$key] ?? $default;
    }

    /**
     * Verifica se o corpo da requisição é JSON
    */
    public function isJson(): bool {
        $contentType = $this->header('Content-Type', '');
        return strpos($contentType, 'application/json') !== false;
    }

    /**
     * Retorna todos os dados combinados (query + body + params)
    */
    public function all(): array {
        return array_merge($this->query, $this->body, $this->params);
    }
}