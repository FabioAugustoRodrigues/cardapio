<?php

namespace app\database;

use \PDO;
use PDOException;

abstract class Conexao{

    private static $conexao;

    public static function getConexao(){
        if (self::$conexao == null) {
            try{
                self::$conexao = new PDO("mysql:host=127.0.0.1;dbname=cardapio;charset=utf8", "root", "root");
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo json_encode("Error: ".$e->getMessage());
            }
        }

        return self::$conexao;
    }

    public static function desconecta(){
        self::$conexao = null;
    }
}