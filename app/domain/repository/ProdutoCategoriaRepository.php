<?php

namespace app\domain\repository;

use app\database\Conexao;
use app\domain\model\Categoria;
use app\domain\model\ProdutoCategoria;
use PDO;

class ProdutoCategoriaRepository
{

    public function criar(ProdutoCategoria $produtoCategoria): int
    {
        $sql = "INSERT INTO produto_categoria (id_produto, id_categoria) VALUES (:id_produto, :id_categoria);";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id_produto', $produtoCategoria->getId_produto());
        $stmt->bindValue(':id_categoria', $produtoCategoria->getId_categoria());
        $result = $stmt->execute();

        if ($result == 0) {
            Conexao::desconecta();

            return 0;
        }

        $id = Conexao::getConexao()->lastInsertId();
        Conexao::desconecta();
        return $id;
    }

    public function leProdutoCategoriaPorIdProduto(int $id_produto): ?ProdutoCategoria
    {
        $sql = "SELECT * FROM produto_categoria WHERE id_produto = :id_produto";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id_produto', $id_produto);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return ProdutoCategoria::create()
            ->setId($result["id"])
            ->setId_produto($result["id_produto"])
            ->setId_categoria($result["id_categoria"]);
    }

    /*
    A entidade no banco de dados permite uma relação N por N, mas como na regra de negócio 
    diz que 1 produto terá apenas 1 categoria, ou seja, 1 por N, então essa função se torna util
    */
    public function leCategoriaPorIdProduto(int $id_produto): ?Categoria
    {
        $sql = "SELECT categoria.* FROM produto_categoria
                INNER JOIN categoria ON categoria.id = produto_categoria.id_categoria
                WHERE produto_categoria.id_produto = :id_produto";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id_produto', $id_produto);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return Categoria::create()
            ->setId($result["id"])
            ->setNome($result["nome"])
            ->setDescricao($result["descricao"]);
    }

    public function atualiza(ProdutoCategoria $produtoCategoria): int
    {
        $sql = "UPDATE produto_categoria SET id_categoria = :id_categoria WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id_categoria', $produtoCategoria->getId_categoria());
        $stmt->bindValue(':id', $produtoCategoria->getId());
        $result = $stmt->execute();
        Conexao::desconecta();

        if (!$result) {
            return false;
        }

        return true;
    }

    public function listarProdutosPorCategoria(): array
    {
        $sql = "SELECT produto.nome, produto.foto, produto.preco, categoria.nome AS 'nomeCategoria' FROM produto_categoria
                INNER JOIN produto ON produto.id = produto_categoria.id_produto
                INNER JOIN categoria ON categoria.id = produto_categoria.id_categoria
                WHERE produto.situacao = 'Habilitado'";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetchAll();

        if (!$result) {
            return [];
        }

        return $result;
    }
}
