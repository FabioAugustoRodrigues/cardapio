<?php

namespace app\domain\service;

use app\domain\auth\AuthAdministrador;
use app\domain\exception\http\DomainHttpException;
use app\domain\model\Administrador;
use app\domain\repository\AdministradorRepository;

class AdministradorService
{
    private $administradorRepository;
    private $authAdministrador;

    public function __construct(AdministradorRepository $administradorRepository, AuthAdministrador $authAdministrador)
    {
        $this->administradorRepository = $administradorRepository;
        $this->authAdministrador = $authAdministrador;
    }

    public function login(string $nome, string $senha): bool
    {
        $administrador = $this->lePorNome($nome);
        if ($administrador == null || !password_verify($senha, $administrador->getSenha())){
            throw new DomainHttpException("Nome ou senha incorretos!");
        }

        $this->authAdministrador->criar($administrador);

        return true;
    }

    public function lePorNome(string $nome): ?Administrador
    {
        return $this->administradorRepository->lePorNome($nome);
    }
}