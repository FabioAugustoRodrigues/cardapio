<?php

namespace app\domain\service;

use app\domain\validacao\Validacao;
use app\domain\exception\http\DomainHttpException;
use app\domain\exception\http\ValidacaoHttpException;
use app\domain\model\Categoria;
use app\domain\repository\CategoriaRepository;

class CategoriaService
{
    private $categoriaRepository;
    private $validacao;

    public function __construct(CategoriaRepository $categoriaRepository, Validacao $validacao)
    {
        $this->categoriaRepository = $categoriaRepository;
        $this->validacao = $validacao;
    }

    public function criar(Categoria $categoria): int
    {
        if ($this->lePorNome($categoria->getNome()) != null){
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        $this->validaCategoria($categoria);
        if ($this->validacao->isSuccess()){
            $categoria->setId($this->categoriaRepository->criar($categoria));
            return $categoria->getId();
        }

        throw new ValidacaoHttpException(implode("\n", $this->validacao->getErrors()), 400);
    }

    public function atualizar(Categoria $categoria): bool
    {
        if ($this->lePorId($categoria->getId()) == null){
            throw new DomainHttpException("Categoria não encotrada", 404);
        }

        $categoriaTemp = $this->lePorNome($categoria->getNome());
        if ($categoriaTemp != null && $categoriaTemp->getId() != $categoria->getId()){
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        $this->validaCategoria($categoria);
        if ($this->validacao->isSuccess()){
            return $this->categoriaRepository->atualizar($categoria);
        }

        throw new ValidacaoHttpException(implode("\n", $this->validacao->getErrors()), 400);
    }

    public function lePorId(int $id): ?Categoria
    {
        return $this->categoriaRepository->lePorId($id);
    }

    public function listar(): array
    {
        return $this->categoriaRepository->listar();
    }

    public function lePorNome(string $nome): ?Categoria
    {
        return $this->categoriaRepository->lePorNome($nome);
    }

    public function validaCategoria(Categoria $categoria)
    {
        $this->validacao->name('Nome')->value($categoria->getNome())->pattern('text')->required();
        $this->validacao->name('Descrição')->value($categoria->getDescricao())->pattern('text')->required();
    }
}