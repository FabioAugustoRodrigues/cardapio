<?php

namespace app\controller\http;

require_once "../../../vendor/autoload.php";

class CollectionRoutes
{
    private static $routes;

    public function __construct()
    {
        self::$routes = array(
            "login-admin" => new Method("app\\controller\\http\\AdministradorController", "login"),
        );
    }

    public function run($post, $route)
    {
        if (array_key_exists($route, self::$routes)) {
            $container = require_once __DIR__ . "../../../config/container.php";
            
            return $container->call([self::$routes[$route]->getClass(), self::$routes[$route]->getMethod()], array($post));
        }

        http_response_code(404);
        return "Rota não encontrada";
    }
}

class Method
{
    private $class;
    private $method;

    public function __construct($class, $method)
    {
        $this->class = $class;
        $this->method = $method;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
