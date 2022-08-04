<?php

namespace app\domain\service;

use app\domain\validacao\Validacao;
use app\domain\exception\http\DomainHttpException;
use app\domain\exception\http\ValidacaoHttpException;
use app\domain\model\Categoria;
use app\domain\model\Produto;
use app\domain\model\ProdutoCategoria;
use app\domain\repository\CategoriaRepository;
use app\domain\repository\ProdutoCategoriaRepository;
use app\domain\repository\ProdutoRepository;
use app\util\FileUtil;

class ProdutoService
{
    private $produtoRepository;
    private $categoriaRepository;
    private $produtoCategoriaRepository;
    private $fileUtil;
    private $validacao;

    public function __construct(ProdutoRepository $produtoRepository, CategoriaRepository $categoriaRepository, ProdutoCategoriaRepository $produtoCategoriaRepository, FileUtil $fileUtil, Validacao $validacao)
    {
        $this->produtoRepository = $produtoRepository;
        $this->categoriaRepository = $categoriaRepository;
        $this->produtoCategoriaRepository = $produtoCategoriaRepository;
        $this->fileUtil = $fileUtil;
        $this->validacao = $validacao;
    }

    public function criar(Produto $produto, array $dadosDaImagem, int $id_categoria): int
    {
        if ($this->lePorNome($produto->getNome()) != null) {
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        if ($this->categoriaRepository->lePorId($id_categoria) == null) {
            throw new DomainHttpException("Categoria não encontrada", 404);
        }

        $produto->setPreco(str_replace(".", "", $produto->getPreco()));
        $produto->setPreco(str_replace(",", ".", $produto->getPreco()));

        $this->validaProduto($produto);
        if ($this->validacao->isSuccess()) {
            $nomeDaImagem = $this->fileUtil->insereImagem($dadosDaImagem, "../../../documentos/fotos/");

            $produto->setFoto($nomeDaImagem);
            $produto->setId($this->produtoRepository->criar($produto));

            $produtoCategoria = ProdutoCategoria::create()
                ->setId(null)
                ->setId_produto($produto->getId())
                ->setId_categoria($id_categoria);
            $produtoCategoria->setId($this->produtoCategoriaRepository->criar($produtoCategoria));

            return $produto->getId();
        }

        throw new ValidacaoHttpException(implode("\n", $this->validacao->getErrors()), 400);
    }

    public function atualizar(Produto $produto, array $dadosDaImagem, int $id_categoria): bool
    {
        $produtoTemp = $this->lePorId($produto->getId());
        if ($produtoTemp == null) {
            throw new DomainHttpException("Produto não encotrado", 404);
        }
        $produto->setFoto($produtoTemp->getFoto());

        $produtoTemp = $this->lePorNome($produto->getNome());
        if ($produtoTemp != null && $produtoTemp->getId() != $produto->getId()) {
            throw new DomainHttpException("Nome já está em uso", 409);
        }

        if ($this->categoriaRepository->lePorId($id_categoria) == null) {
            throw new DomainHttpException("Categoria não encontrada", 404);
        }

        $produto->setPreco(str_replace(".", "", $produto->getPreco()));
        $produto->setPreco(str_replace(",", ".", $produto->getPreco()));

        $this->validaProduto($produto);
        if ($this->validacao->isSuccess()) {
            if (isset($dadosDaImagem["type"])) {
                $this->fileUtil->excluiArquivo("../../../documentos/fotos/" . $produto->getFoto());
                $nomeDaImagem = $this->fileUtil->insereImagem($dadosDaImagem, "../../../documentos/fotos/");
                $produto->setFoto($nomeDaImagem);
            }

            $this->produtoRepository->atualizar($produto);

            $produtoCategoria = $this->produtoCategoriaRepository->leProdutoCategoriaPorIdProduto($produto->getId());
            $produtoCategoria->setId_categoria($id_categoria);
            return $this->produtoCategoriaRepository->atualiza($produtoCategoria);
        }

        throw new ValidacaoHttpException(implode("\n", $this->validacao->getErrors()), 400);
    }

    public function excluir(int $id): bool
    {
        $produtoTemp = $this->lePorId($id);
        if ($produtoTemp == null) {
            throw new DomainHttpException("Produto não encotrado", 404);
        }

        $this->fileUtil->excluiArquivo("../../../documentos/fotos/" . $produtoTemp->getFoto());

        return $this->produtoRepository->excluir($id);
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

    public function listarPorCategoria(): array
    {
        return $this->organizaProdutosPorCategoria($this->produtoCategoriaRepository->listarProdutosPorCategoria());
    }

    public function organizaProdutosPorCategoria(array $catalogoDesorganizado): array
    {
        $catalogoOrganizado = array();
        $categoriaAtual = "";
        for ($i = 0; $i < count($catalogoDesorganizado); $i++) { // 0(n)
            if ($categoriaAtual != $catalogoDesorganizado[$i]["nomeCategoria"]) {
                $categoriaAtual = $catalogoDesorganizado[$i]["nomeCategoria"];
                $catalogoOrganizado[$catalogoDesorganizado[$i]["nomeCategoria"]] = array();
            }

            $produtoEncontrado["nome"] = $catalogoDesorganizado[$i]["nome"];
            $produtoEncontrado["foto"] = $catalogoDesorganizado[$i]["foto"];
            $produtoEncontrado["preco"] = $catalogoDesorganizado[$i]["preco"];

            array_push($catalogoOrganizado[$categoriaAtual], $produtoEncontrado);
        }

        return $catalogoOrganizado;
    }

    public function validaProduto(Produto $produto)
    {
        $this->validacao->name('Nome')->value($produto->getNome())->pattern('text')->required();
        $this->validacao->name('Preço')->value($produto->getPreco())->pattern('float')->required();
    }
}
