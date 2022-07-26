<?php

namespace app\domain\model;

use app\domain\model\ModelAbstract;

class ProdutoCategoria extends ModelAbstract
{

    private $id;
    private $id_produto;
    private $id_categoria;

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

    public function getId_produto()
    {
        return $this->id_produto;
    }

    public function setId_produto($id_produto)
    {
        $this->id_produto = $id_produto;
        return $this;
    }

    public function getId_categoria()
    {
        return $this->id_categoria;
    }

    public function setId_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
        return $this;
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "id_produto" => $this->id_produto,
            "id_categoria" => $this->id_categoria
        ];
    }
}
