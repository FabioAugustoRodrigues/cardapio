<?php

namespace app\auth\administracao;

use app\domain\auth\AuthAbstract;
use app\domain\exception\DomainException;
use app\domain\model\Administrador;
use app\domain\model\ModelAbstract;
use Exception;

class AuthAdministrador extends AuthAbstract{

    public function __construct(){
        parent::removeAuths();
    }

    public function criar(ModelAbstract $administrador): bool
    {
        if (!($administrador instanceof Administrador)){
            throw new DomainException("Houve um erro ao tentar realizar o login");
        }

        $_SESSION["administrador_logado"] = serialize($administrador);
        $_SESSION["administrador_esta_logado"] = true;

        return true;
    }

    public function verificar(): bool
    {
        try {
            if (!(isset($_SESSION['administrador_esta_logado']) || !$_SESSION['administrador_esta_logado'])){
                header('Location: /');
            }

            return true;
        } catch (Exception $e) {
            header('Location: /');
            echo $e->getMessage();
        }
    }
}