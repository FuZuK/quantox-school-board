<?php

class Application
{
    private $config;
    private $routes;
    private $routesHandlers;

    public function __construct($config, $routes)
    {
        $this->config = $config;
        $this->routes = $routes;
    }

    public function run() {
        $this->initSession();
        $this->initDatabaseConnection();
        $this->initRoutes();

        echo $this->handleRequest();
    }

    private function initSession() {
        session_start();
    }

    private function initDatabaseConnection() {
        $db_config = $this->config['db'];
        Database::initConnection(
            $db_config['driver'], $db_config['host'], $db_config['port'],
            $db_config['user'], $db_config['password'], $db_config['db_name']
        );
    }

    private function initRoutes() {
        foreach ($this->routes as $routeDefinition => $routeHandlerString) {
            if (!preg_match('/^([A-Z]*) (.*)$/', $routeDefinition, $matches)) {
                continue;
            }

            $httpMethod = $matches[1];
            $routeUri = $matches[2];
            $routeRegex = static::getRouteRegex($routeUri);
            $routePlaceholders = static::getRoutePlaceholders($routeUri);
            $routeController = static::getRouteController($routeHandlerString);
            $routeControllerMethod = static::getRouteControllerMethod($routeHandlerString);

            $this->routesHandlers[] = [
                'httpMethod' => $httpMethod,
                'regex' => $routeRegex,
                'placeholders' => $routePlaceholders,
                'controller' => $routeController,
                'method' => $routeControllerMethod
            ];
        }
    }

    private function handleRequest() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routesHandlers as $routerInfo) {
            if ($method === $routerInfo['httpMethod']
                && preg_match('/' . $routerInfo['regex'] . '/', $uri, $matches)) {
                $arguments = static::buildRouteArguments(array_slice($matches, 1), $routerInfo['placeholders']);
                return $this->callRouteHandler(
                    $routerInfo['controller'],
                    $routerInfo['method'],
                    $arguments,
                    $_POST
                );
            }
        }
    }

    private function callRouteHandler($controller, $method, $arguments, $data) {
        $controllerPath = 'Controllers\\' . $controller;
        $controllerInstance = new $controllerPath($this->config);

        error_log('Calling ' . $controllerPath . '::' . $method);

        return $controllerInstance->$method($arguments, $data);
    }

    private static function getRouteRegex($routeUri) {
        $regex = preg_replace('/:[a-zA-Z0-9]*/', '([a-zA-Z0-9]*)', $routeUri);
        $regex = preg_replace('/\//', '\/', $regex);

        return '^' . $regex . '$';
    }

    private static function getRoutePlaceholders($routeUri) {
        if (preg_match_all('/:([a-zA-Z0-9]*)/', $routeUri, $matches)) {
            return array_values($matches[1]);
        }

        return [];
    }

    private static function getRouteController($routeHandlerString) {
        if (preg_match('/^(.+?)\..+?$/', $routeHandlerString, $match)) {
            return $match[1];
        }

        return null;
    }

    private static function getRouteControllerMethod($routeHandlerString) {
        if (preg_match('/^.+?\.(.+?)$/', $routeHandlerString, $match)) {
            return $match[1];
        }

        return null;
    }

    private static function buildRouteArguments($matches, $placeholders) {
        $arguments = [];

        foreach ($placeholders as $index => $placeholder) {
            $arguments[$placeholder] = $matches[$index];
        }

        return $arguments;
    }
}
