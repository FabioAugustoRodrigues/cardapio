<?php

namespace app\domain\repository;

use app\database\Conexao;
use app\domain\model\Produto;
use PDO;

class ProdutoRepository
{

    public function criar(Produto $produto): int
    {
        $sql = "INSERT INTO produto (nome, preco, foto, situacao) VALUES (:nome, :preco, :foto, :situacao);";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':foto', $produto->getFoto());
        $stmt->bindValue(':situacao', $produto->getSituacao());
        $result = $stmt->execute();

        if ($result == 0) {
            Conexao::desconecta();

            return 0;
        }

        $id = Conexao::getConexao()->lastInsertId();
        Conexao::desconecta();
        return $id;
    }

    public function atualizar(Produto $produto): bool
    {
        $sql = "UPDATE produto SET nome = :nome, preco = :preco, foto = :foto, situacao = :situacao WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':foto', $produto->getPreco());
        $stmt->bindValue(':situacao', $produto->getSituacao());
        $stmt->bindValue(':id', $produto->getId());
        $result = $stmt->execute();
        Conexao::desconecta();

        if (!$result) {
            return false;
        }

        return true;
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM produto";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetchAll();

        if (!$result) {
            return [];
        }

        return $result;
    }

    public function excluir($id): bool
    {
        $sql = "DELETE FROM produto WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
        Conexao::desconecta();

        if (!$result) {
            return false;
        }

        return true;
    }

    public function lePorNome(string $nome): ?Produto
    {
        $sql = "SELECT * FROM produto WHERE nome = :nome";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return Produto::create()
                            ->setId($result["id"])
                            ->setNome($result["nome"])
                            ->setPreco($result["preco"])
                            ->setFoto($result["foto"])
                            ->setSituacao($result["situacao"]);
    }

    public function lePorId(int $id): ?Produto
    {
        $sql = "SELECT * FROM produto WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return Produto::create()
                            ->setId($result["id"])
                            ->setNome($result["nome"])
                            ->setPreco($result["preco"])
                            ->setFoto($result["foto"])
                            ->setSituacao($result["situacao"]);
    }
}