<?php

namespace app\domain\repository;

use app\database\Conexao;
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
}
