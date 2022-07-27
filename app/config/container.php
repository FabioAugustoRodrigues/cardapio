<?php

use app\domain\auth\AuthAdministrador;
use app\domain\repository\AdministradorRepository;
use app\domain\repository\CategoriaRepository;
use app\domain\service\AdministradorService;
use app\domain\service\CategoriaService;
use app\helper\http\PayloadHttp;
use app\util\JsonMapper;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    PayloadHttp::class => new PayloadHttp(),
    JsonMapper::class => new JsonMapper(),
    AuthAdministrador::class => new AuthAdministrador(),
    AdministradorRepository::class => new AdministradorRepository(),
    CategoriaRepository::class => new CategoriaRepository(),
    AdministradorService::class => function (ContainerInterface $container) {
        $administradorRepository = $container->get(AdministradorRepository::class);
        $authAdministrador = $container->get(AuthAdministrador::class);

        return new AdministradorService($administradorRepository, $authAdministrador);
    },
    CategoriaService::class => function (ContainerInterface $container){
        $categoriaRepository = $container->get(CategoriaRepository::class);

        return new CategoriaService($categoriaRepository);
    }
]);

return $containerBuilder->build();