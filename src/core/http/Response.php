<?php

namespace MyProject\core\http;

/*  Benefícios de usar static aqui:

    Praticidade: não precisa criar new Response() toda vez.
    Sem estado: a classe não guarda dados entre chamadas, então não há necessidade de instância.
    Organização: agrupa funções relacionadas à resposta HTTP num lugar só. 
    self:: é usado para acessar membros estáticos da própria classe onde você está.
    : void indica que a função não retorna nenhum valor.
    */

class Response {    
    /**
     * Retorna o dado em json padrão
    */    
    public static function json($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Retorna sucesso para Json padronizado
     */
    public static function success($data, int $status = 200): void {
        self::json([
            'isValid' => true,
            'data' => $data
        ], $status);
    }

    /**
     * Retorna erro para Json padronizado
    */
    public static function error(string $message, int $status = 400, array $details = []):void {
        $response = [
            'isValid' => false,
            'message' => $message
        ];

        if(!empty($details)) {
            $response['errors'] = $details;
        }

        self::json($response, $status);
    }

    public static function text(string $content, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: text/plain; charset=utf-8');
        echo $content;
    }

    public static function html(string $html, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }    

    public static function redirect(string $url, int $status = 302): void {
        http_response_code($status);
        header("Location: $url");
        exit;
    }
}