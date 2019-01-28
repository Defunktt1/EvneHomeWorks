<?php

namespace application\core;

class Route
{
    public static function get($route, $controller)
    {
        $server = $_SERVER;
        $uri = explode('/', $server['REQUEST_URI']);
        $controllerName = 'HomeController';
        $actionName = 'index';

        $url = '';
        foreach ($uri as $uriPart) {
            if (!empty($uriPart)) {
                $url .= $uriPart . '/';
            }
        }

        if ($server['REQUEST_METHOD'] === 'GET' && $url === strtolower($route)) {
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