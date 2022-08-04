<?php

// Aqui fazemos a autenticação do administrador

require_once '../../../vendor/autoload.php';

session_start();

use app\domain\auth\AuthAdministrador;

$authAdministrador = new AuthAdministrador();
$authAdministrador->verificar();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="content-language" content="pt-br">
    <meta property="og:locale" content="pt_BR">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- CDN Bootstrap 5.0.0-beta1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Arquivos CSS -->
    <link rel="stylesheet" href="../app/view/css/style.css" />
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Nome do sistema</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/cardapio/catalogo/">Catalogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/cardapio/categorias/">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/cardapio/produtos/">Produtos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="bg-light p-5 rounded">
            <h1>Categorias</h1>

            <table class="table" id="categoriasCadastradas">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button class="btn btn-primary w-25" id="abrirModalCadastrarCategoria">Cadastrar</button>
        </div>
    </main>

    <div id="modalCadastrarCategoria" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioCadastrarCategoria" novalidate>
                        <div class="mb-3">
                            <label for="cadastrarNomeCategoria" class="form-label">Nome: </label>
                            <input type="text" class="form-control" id="cadastrarNomeCategoria" required>
                        </div>
                        <div class="mb-3">
                            <label for="cadastrarDescricaoCategoria" class="form-label">Descrição: </label>
                            <textarea class="form-control" id="cadastrarDescricaoCategoria" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="salvarCategoria">Salvar categoria</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalEditarCategoria" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioEditarCategoria" novalidate>
                        <input type="hidden" id="idDaCategoriaSelecionada" />

                        <div class="mb-3">
                            <label for="editarNomeCategoria" class="form-label">Nome: </label>
                            <input type="text" class="form-control" id="editarNomeCategoria" required>
                        </div>
                        <div class="mb-3">
                            <label for="editarDescricaoCategoria" class="form-label">Descrição: </label>
                            <textarea class="form-control" id="editarDescricaoCategoria" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="editarCategoria">Salvar alterações</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CDN Jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- CDN SweetAlert JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Meus arquivos JS -->
    <script src="../app/view/js/funcs.js"></script>
    <script src="../app/view/js/categorias.js"></script>

    <script>
        listar();
    </script>

</body>

</html>