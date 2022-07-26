<?php

namespace app\domain\model;

use app\domain\model\ModelAbstract;

class Produto extends ModelAbstract
{

    private $id;
    private $nome;
    private $preco;
    private $foto;
    private $situacao;

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

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
        return $this;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
        return $this;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "preco" => $this->preco,
            "foto" => $this->foto,
            "situacao" => $this->situacao
        ];
    }
}
