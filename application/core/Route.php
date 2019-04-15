<?php

namespace application\core;

class Route
{
    public static function get($route, $controller)
    {
        $server = $_SERVER;
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        if (substr($uri, -1) !== '/') {
            $uri .= '/';
        }

        $controllerName = 'HomeController';
        $actionName = 'index';

        if (($server['REQUEST_METHOD'] === 'GET' || $server['REQUEST_METHOD'] === 'POST') && $uri === strtolower($route)) {
            $controllerData = explode('@', $controller);
            $controllerName = $controllerData[0];
            $controllerFile = $controllerName . '.php';
            $actionName = $controllerData[1];
            include 'application/controllers/' . $controllerFile;
            $controller = new $controllerName();
            $controller->$actionName();
            exit;
        }
    }

    public static function abort()
    {
        $controller = new \Controller();
        $controller->get404();
    }
}