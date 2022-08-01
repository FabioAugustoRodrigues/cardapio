<?php

namespace app\domain\service;

use app\domain\exception\http\DomainHttpException;
use app\domain\model\Categoria;
use app\domain\model\Produto;
use app\domain\model\ProdutoCategoria;
use app\domain\repository\CategoriaRepository;
use app\domain\repository\ProdutoCategoriaRepository;
use app\domain\repository\ProdutoRepository;

class ProdutoService
{
    private $produtoRepository;
    private $categoriaRepository;
    private $produtoCategoriaRepository;

    public function __construct(ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository, ProdutoCategoriaRepository $produtoCategoriaRepository)
    {
        $this->produtoRepository = $produtoRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->produtoCategoriaRepository = $produtoCategoriaRepository;
    }

    public function criar(Produto $produto, int $id_categoria): int
    {
        if ($this->lePorNome($produto->getNome()) != null) {
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        if ($this->categoriaRepository->lePorId($id_categoria) == null) {
            throw new DomainHttpException("Categoria não encontrada", 404);
        }

        $produto->setId($this->produtoRepository->criar($produto));

        $produtoCategoria = ProdutoCategoria::create()
            ->setId(null)
            ->setId_produto($produto->getId())
            ->setId_categoria($id_categoria);
        $produtoCategoria->setId($this->produtoCategoriaRepository->criar($produtoCategoria));

        return $produto->getId();
    }

    public function atualizar(Produto $produto, int $id_categoria): bool
    {
        if ($this->lePorId($produto->getId()) == null) {
            throw new DomainHttpException("Produto não encotrado", 404);
        }

        $produtoTemp = $this->lePorNome($produto->getNome());
        if ($produtoTemp != null && $produtoTemp->getId() != $produto->getId()) {
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        if ($this->categoriaRepository->lePorId($id_categoria) == null) {
            throw new DomainHttpException("Categoria não encontrada", 404);
        }
        
        $this->produtoRepository->atualizar($produto);
        
        $produtoCategoria = $this->produtoCategoriaRepository->leProdutoCategoriaPorIdProduto($produto->getId());
        $produtoCategoria->setId_categoria($id_categoria);
        return $this->produtoCategoriaRepository->atualiza($produtoCategoria);
    }

    public function lePorId(int $id): ?Produto
    {
        return $this->produtoRepository->lePorId($id);
    }

    public function leCategoriaPorIdProduto(int $id_produto): ?Categoria
    {
        return $this->produtoCategoriaRepository->leCategoriaPorIdProduto($id_produto);
    }

    public function listar(): array
    {
        return $this->produtoRepository->listar();
    }

    public function lePorNome(string $nome): ?Produto
    {
        return $this->produtoRepository->lePorNome($nome);
    }
}
