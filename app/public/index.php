<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/config.php';

$route = $_GET['route'] ?? 'form';
$routeParts = explode('/', $route);

$controllerName = ucfirst(strtolower($routeParts[0])) . 'Controller';
$controllerClass = 'App\\Controllers\\' . $controllerName;

$methodName = $routeParts[1] ?? 'index';

$params = array_slice($routeParts, 2);

try {
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        } else {
            throw new Exception("Method $methodName not found in controller $controllerName.");
        }
    } else {
        throw new Exception("Controller $controllerName not found.");
    }
} catch (Exception $e) {
    http_response_code(404);
    echo $e->getMessage();
}
