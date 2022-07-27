<?php

namespace app\domain\repository;

use app\database\Conexao;
use app\domain\model\Categoria;
use PDO;

class CategoriaRepository
{

    public function criar(Categoria $categoria): int
    {
        $sql = "INSERT INTO categoria (nome, descricao) VALUES (:nome, :descricao);";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $categoria->getNome());
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $result = $stmt->execute();

        if ($result == 0) {
            Conexao::desconecta();

            return 0;
        }

        $id = Conexao::getConexao()->lastInsertId();
        Conexao::desconecta();
        return $id;
    }

    public function atualizar(Categoria $categoria): bool
    {
        $sql = "UPDATE categoria SET nome = :nome, descricao = :descricao WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $categoria->getNome());
        $stmt->bindValue(':descricao', $categoria->getDescricao());
        $stmt->bindValue(':id', $categoria->getId());
        $result = $stmt->execute();
        Conexao::desconecta();

        if (!$result) {
            return false;
        }

        return true;
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM categoria";
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
        $sql = "DELETE FROM categoria WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
        $result = $stmt->execute();
        Conexao::desconecta();

        if (!$result) {
           return false;
        }

        return true;
    }

    public function lePorId($id): ?Categoria
    {
        $sql = "SELECT * FROM categoria WHERE id = :id";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':id', $id);
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

    public function lePorNome(string $nome): ?Categoria
    {
        $sql = "SELECT * FROM categoria WHERE nome = :nome";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $nome);
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
}