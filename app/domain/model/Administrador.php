<?php

namespace app\domain\model;

use app\domain\model\ModelAbstract;

class Administrador extends ModelAbstract
{

    private $id;
    private $nome;
    private $senha;

    public static function create()
    {
        return new self();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "senha" => $this->senha
        ];
    }
}
