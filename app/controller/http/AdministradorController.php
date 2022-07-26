<?php

namespace app\controller\http;

use app\domain\exception\DomainException;
use app\domain\exception\http\DomainHttpException;
use app\domain\service\AdministradorService;

require_once '../../../vendor/autoload.php';

class AdministradorController extends ControllerAbstract
{

    private $administradorService;

    public function __construct(AdministradorService $administradorService)
    {
        $this->administradorService = $administradorService;
    }

    public function login($dados)
    {
        try {
            if (!$this->administradorService->login($dados["nome"], $dados["senha"])) {
                return $this->respondeComDados("Houve um erro ao tetnar realizar o login", 500);
            }
        } catch (DomainHttpException $domainHttpException) {
            return $this->respondeComDados($domainHttpException->getMessage(), $domainHttpException->getHttpStatusCode());
        } catch (DomainException $domainException) {
            return $this->respondeComDados($domainException->getMessage(), 500);
        }

        return $this->respondeComDados("Login realizado com sucesso!", 200);
    }
}
