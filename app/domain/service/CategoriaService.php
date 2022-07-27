<?php

namespace app\domain\service;

use app\domain\exception\http\DomainHttpException;
use app\domain\model\Categoria;
use app\domain\repository\CategoriaRepository;

class CategoriaService
{
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criar(Categoria $categoria): int
    {
        if ($this->lePorNome($categoria->getNome()) != null){
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        $categoria->setId($this->categoriaRepository->criar($categoria));
        return $categoria->getId();
    }

    public function listar(): array
    {
        return $this->categoriaRepository->listar();
    }

    public function lePorNome(string $nome): ?Categoria
    {
        return $this->categoriaRepository->lePorNome($nome);
    }
}