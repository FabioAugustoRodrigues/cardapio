<?php

use app\auth\administracao\AuthAdministrador;
use app\domain\repository\AdministradorRepository;
use app\domain\service\AdministradorService;
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
    AdministradorService::class => function (ContainerInterface $container) {
        $administradorRepository = $container->get(AdministradorRepository::class);
        $authAdministrador = $container->get(AuthAdministrador::class);

        return new AdministradorService($administradorRepository, $authAdministrador);
    },
]);

return $containerBuilder->build();