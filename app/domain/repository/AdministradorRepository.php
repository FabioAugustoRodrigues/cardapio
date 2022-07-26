<?php

namespace app\domain\repository;

use app\database\Conexao;
use app\domain\model\Administrador;

class AdministradorRepository
{
    public function lePorNome($nome)
    {
        $sql = "SELECT * FROM administrador WHERE nome = :nome";
        $stmt = Conexao::getConexao()->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        Conexao::desconecta();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return Administrador::create()
                            ->setId($result["id"])
                            ->setNome($result["nome"])
                            ->setSenha($result["senha"]);
    }
}