<?php
namespace Datnn\Core;

class Router
{
    private $routes = [];
    private $params = [];

    public static function load()
    {
        $router = new static;

        require_once __DIR__ . '/../config/routes.php';

        $router->setParams();
        $router->redirect();
    }

    public function route(string $route, array $params = [])
    {
        if (isset($params['method']) && $_SERVER['REQUEST_METHOD'] !== $params['method']) {
            return;
        }
        $route = preg_replace('/\//', '\\/', $route);

        $route = preg_replace('/\{([a-z0-9]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);

        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function setParams()
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $this->getUri(), $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if ($key === 'controller') {
                            $match = ucwords($match);
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
            }
        }
    }

    public function redirect()
    {
        if(!isset($this->params['controller']) || !isset($this->params['action'])) {
            echo JsonResponse::getResponse(404, "Method not found");
            die();
        }
        $controller = $this->getNamespace() . $this->params['controller'];
        $action = $this->params['action'];
        if (class_exists($controller)) {
            $controller = new $controller;
            if (is_callable([$controller, $action])) {
                unset($this->params['controller']);
                unset($this->params['action']);
                unset($this->params['namespace']);
                call_user_func_array([$controller, $action], [new HttpRequest($this->params)]);
            } else {
                echo JsonResponse::getResponse(404, "Method not found");
            }
        } else {
            echo JsonResponse::getResponse(404, "Method not found");
        }
    }

    private function getNamespace()
    {
        $namespace = '\\Datnn\\Controller\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

    private function getUri()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri = explode('/', $uri);
        $uri = implode('/', $uri);

        return $uri;
    }
}
