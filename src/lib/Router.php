<?php

namespace Lib;

class Router
{
    private $routes = [];
    private $basePath = '';

    public function __construct($basePath = '')
    {
        $this->basePath = $basePath;
    }

    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path from URI
        if (strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }
        
        $requestUri = '/' . trim($uri, '/');

        foreach ($this->routes as $route) {
            // Convert path to regex: /users/:id -> /users/(\w+)
            $pattern = preg_replace('/:(\w+)/', '(?<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                if (is_callable($route['handler'])) {
                    call_user_func_array($route['handler'], $params);
                    return;
                }

                if (is_string($route['handler']) && strpos($route['handler'], '@') !== false) {
                    list($controllerClass, $method) = explode('@', $route['handler']);

                    // The autoloader should handle file inclusion
                    if (class_exists($controllerClass)) {
                        // This is a temporary solution for dependency injection
                        require_once __DIR__ . '/../config/config.php';
                        
                        $controllerInstance = new $controllerClass($pdo);
                        
                        if (method_exists($controllerInstance, $method)) {
                            header('Content-Type: application/json');
                            echo call_user_func_array([$controllerInstance, $method], $params);
                            return;
                        }
                    }
                }
                
                // Handle simple view inclusion
                if (is_string($route['handler'])) {
                    $viewFile = __DIR__ . '/../../views/pages/' . $route['handler'] . '.php';
                    if (file_exists($viewFile)) {
                        include $viewFile;
                        return;
                    }
                }
            }
        }

        // Not found
        http_response_code(404);
        include __DIR__ . '/../../views/pages/notfound.php';
    }
}
