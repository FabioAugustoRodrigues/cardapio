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
            "criar-categoria" => new Method("app\\controller\\http\\CategoriaController", "criar"),
            "listar-categorias" => new Method("app\\controller\\http\\CategoriaController", "listar"),
            "ler-categoria-por-id" => new Method("app\\controller\\http\\CategoriaController", "lerPorId"),
            "editar-categoria"=> new Method("app\\controller\\http\\CategoriaController", "atualizar"),
            "criar-produto" => new Method("app\\controller\\http\\ProdutoController", "criar"),
            "listar-produtos" => new Method("app\\controller\\http\\ProdutoController", "listar"),
            "ler-produto-por-id" => new Method("app\\controller\\http\\ProdutoController", "lerPorId"),
            "editar-produto"=> new Method("app\\controller\\http\\ProdutoController", "atualizar"),
            "excluir-produto"=> new Method("app\\controller\\http\\ProdutoController", "excluir"),
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
