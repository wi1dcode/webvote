<?php

namespace Core;

class Router
{
    public function route()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = strtok($uri, '?');

        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($base !== '' && $base !== '.' && strpos($path, $base) === 0) {
            $path = substr($path, strlen($base));
        }

        $path = ltrim($path, '/');
        $segments = $path === '' ? [] : explode('/', $path);

        $controllerName = isset($segments[0]) && $segments[0] !== '' ? ucfirst($segments[0]) . 'Controller' : 'IndexController';
        $methodName = isset($segments[1]) && $segments[1] !== '' ? $segments[1] : 'index';

        $controllerClass = '\\App\\Controller\\' . $controllerName;
        $controllerPath = ROOT_PATH . '/App/Controller/' . $controllerName . '.php';

        if (!file_exists($controllerPath)) {
            $controllerClass = '\\App\\Controller\\IndexController';
        }

        $controller = new $controllerClass;

        if (!method_exists($controller, $methodName)) {
            $methodName = 'index';
        }

        $params = array_slice($segments, 2);
        call_user_func_array([$controller, $methodName], $params);
    }
}
