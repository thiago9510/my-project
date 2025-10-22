<?php

namespace MyProject\routes;

use MyProject\core\http\Request;

class Router {
    private array $routes;

    public function __construct(array $routes) {
        $this->routes = $routes;
    }

    public function handle(string $uri, string $method): void {
        $path = rtrim(parse_url($uri, PHP_URL_PATH), "/");

        foreach ($this->routes as $route) {
            $routeMethod = $route['method'];
            $routePath = $route['path'];
            $handler = $route['handler'];
            $middlewares = $route['middleware'] ?? [];

            // Transforma /users/{id} em regex
            $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $routePath);
            $pattern = "#^" . rtrim($pattern, '/') . "$#";

            if ($routeMethod === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches); // remove o match completo

                // Cria o Request e injeta os parâmetros
                $request = new Request();
                $request->setParams($matches);

                // Executa os middlewares em ordem
                foreach ($middlewares as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    $middleware->handle($request);
                }

                // Executa o controller
                [$controllerClass, $action] = $handler;
                $controller = new $controllerClass();
                $controller->$action($request);
                return;
            }
        }

        // Se nenhuma rota bater
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