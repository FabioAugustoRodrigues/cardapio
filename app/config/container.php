<?php

use app\domain\auth\AuthAdministrador;
use app\domain\model\Categoria;
use app\domain\repository\AdministradorRepository;
use app\domain\repository\CategoriaRepository;
use app\domain\repository\ProdutoCategoriaRepository;
use app\domain\repository\ProdutoRepository;
use app\domain\service\AdministradorService;
use app\domain\service\CategoriaService;
use app\domain\service\ProdutoService;
use app\helper\http\PayloadHttp;
use app\util\FileUtil;
use app\util\JsonMapper;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    PayloadHttp::class => new PayloadHttp(),
    JsonMapper::class => new JsonMapper(),
    FileUtil::class => new FileUtil(),
    AuthAdministrador::class => new AuthAdministrador(),
    AdministradorRepository::class => new AdministradorRepository(),
    CategoriaRepository::class => new CategoriaRepository(),
    ProdutoRepository::class => new ProdutoRepository(),
    ProdutoCategoriaRepository::class => new ProdutoCategoriaRepository(),
    AdministradorService::class => function (ContainerInterface $container) {
        $administradorRepository = $container->get(AdministradorRepository::class);
        $authAdministrador = $container->get(AuthAdministrador::class);

        return new AdministradorService($administradorRepository, $authAdministrador);
    },
    CategoriaService::class => function (ContainerInterface $container){
        $categoriaRepository = $container->get(CategoriaRepository::class);

        return new CategoriaService($categoriaRepository);
    },
    ProdutoService::class => function (ContainerInterface $container){
        $produtoRepository = $container->get(ProdutoRepository::class);
        $categoriaRepository = $container->get(CategoriaRepository::class);
        $produtoCategoriaRepository = $container->get(ProdutoCategoriaRepository::class);
        $fileUtil = $container->get(FileUtil::class);

        return new ProdutoService($produtoRepository, $categoriaRepository, $produtoCategoriaRepository, $fileUtil);
    }
]);

return $containerBuilder->build();