<?php

namespace app\controller\http;

use app\domain\exception\DomainException;
use app\domain\exception\http\DomainHttpException;
use app\domain\model\Categoria;
use app\domain\model\Produto;
use app\domain\service\CategoriaService;
use app\domain\service\ProdutoService;
use app\util\JsonMapper;

require_once '../../../vendor/autoload.php';

class ProdutoController extends ControllerAbstract
{

    private $produtoService;
    private $jsonMapper;

    public function __construct(ProdutoService $produtoService, JsonMapper $jsonMapper)
    {
        $this->produtoService = $produtoService;
        $this->jsonMapper = $jsonMapper;
    }

    public function criar($dados)
    {
        try {
            $dadosDoProdutoEmArray = ["nome" => $dados["nome"], "preco" => $dados["preco"], "foto" => "", "situacao" => "Habilitado"];

            $produto = (object) $this->jsonMapper->map($dadosDoProdutoEmArray, new Produto());
            $id = $this->produtoService->criar($produto, $dados["file"], intval($dados["id_categoria"]));

            $resultado = [
                "id" => $id
            ];

            return $this->respondeComDados($resultado, 201);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function listar($dados)
    {
        try {
            return $this->respondeComDados($this->produtoService->listar(), 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function lerPorId($dados)
    {
        try {
            $produto = $this->produtoService->lePorId($dados["id"]);
            if ($produto == null) {
                return $this->respondeComDados(null, 200);
            }

            $categoria = $this->produtoService->leCategoriaPorIdProduto($produto->getId());

            return $this->respondeComDados(
                [
                    "produto" => $produto->toArray(),
                    "categoria" => $categoria->toArray()
                ],
                200
            );
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function atualizar($dados)
    {
        try {
            $dadosDoProdutoEmArray = ["id"=>intval($dados["id"]), "nome" => $dados["nome"], "preco" => $dados["preco"], "foto" => "", "situacao" => $dados["situacao"]];

            $produto = (object) $this->jsonMapper->map($dadosDoProdutoEmArray, new Produto());
            $this->produtoService->atualizar($produto, $dados["file"]=="null"?[]:$dados["file"], intval($dados["id_categoria"]));

            return $this->respondeComDados("Produto atualizado com sucesso!", 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function excluir($dados)
    {
        try {
            $this->produtoService->excluir($dados["id"]);

            return $this->respondeComDados("Produto deletado com sucesso!", 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function listarCatalogo($dados){
        try {
            $produtosListadosPorCategoria = $this->produtoService->listarPorCategoria();

            return $this->respondeComDados($produtosListadosPorCategoria, 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }
}
