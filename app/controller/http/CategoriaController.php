<?php

namespace app\controller\http;

use app\domain\exception\DomainException;
use app\domain\exception\http\DomainHttpException;
use app\domain\model\Categoria;
use app\domain\service\CategoriaService;
use app\util\JsonMapper;

require_once '../../../vendor/autoload.php';

class CategoriaController extends ControllerAbstract
{

    private $categoriaService;
    private $jsonMapper;

    public function __construct(CategoriaService $categoriaService, JsonMapper $jsonMapper)
    {
        $this->categoriaService = $categoriaService;
        $this->jsonMapper = $jsonMapper;
    }

    public function criar($dados)
    {
        try {
            $dadosDaCategoriaEmArray = ["nome" => $dados["nome"], "descricao" => $dados["descricao"]];

            $categoria = (object) $this->jsonMapper->map($dadosDaCategoriaEmArray, new Categoria());
            $id = $this->categoriaService->criar($categoria);

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
            return $this->respondeComDados($this->categoriaService->listar(), 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function lerPorId($dados)
    {
        try {
            $categoria = $this->categoriaService->lePorId($dados["id"]);
            if ($categoria == null) {
                return $this->respondeComDados(null, 200);
            }

            return $this->respondeComDados($categoria->toArray(), 200);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }

    public function atualizar($dados)
    {
        try {
            $dadosDaCategoriaEmArray = ["id" => $dados["id"], "nome" => $dados["nome"], "descricao" => $dados["descricao"]];

            $categoria = (object) $this->jsonMapper->map($dadosDaCategoriaEmArray, new Categoria());
            // $categoria->setId(intval($dados["id"]));
            $this->categoriaService->atualizar($categoria);

            return $this->respondeComDados("Categoria atualizada com sucesso!", 201);
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }
    }
}
