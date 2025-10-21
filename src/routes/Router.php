<?php

namespace MyProject\routes;

class Router {
    private $routes;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }
    
    public function handle($uri, $method) {
        $path = rtrim(parse_url($uri, PHP_URL_PATH), "/");

        foreach($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($routeMethod === $method && $routePath === $path) {
                [$controllerClass, $action] = explode('@', $handler);
                $controller = new $controllerClass();              
                return $controller->$action();
            }
        }
        // Só chega aqui se nenhuma rota bater
        http_response_code(404);
        echo "Página ou rota não encontrada.";
    }
}



## somente a primeira forma de acessar as rotas HardCode

/* use MyProject\controllers\PersonController;
class RouterExemple {
    public function handle($uri, $method) {        
        $path = rtrim(parse_url($uri, PHP_URL_PATH), "/");

        if ($path === '/persons' && $method === 'GET') {
            $controller = new PersonController();
            $controller->listAll();
            return;
        }

        if ($path === '/api/persons' && $method === 'GET') {
             echo 'aa';
            return;
            #$controller = new PersonController();
            #$controller->apiListAll();
            #return;
        }

        http_response_code(404);        
        echo "Página ou rota não encontrada.";
    }
}

 */