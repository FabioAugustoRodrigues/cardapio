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

    <section class="h-100 mt-2">
        <div class="card-wrapper">
            <div id="boxLogin" class="card fat">
                <div class="card-body m-3">
                    <h4 class="card-title">Acessar painel do administrador</h4>
                    <form id="loginPainelAdmin" method="POST" class="mt-5" novalidate>
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input id="nome" type="nome" class="form-control mt-2" name="nome" value="" required autofocus>
                        </div>

                        <div class="form-group mt-3">
                            <label for="senha" class="float-start">Senha</label>
                            <input id="senha" type="password" class="form-control mt-2" name="senha" required data-eye>
                        </div>

                        <div class="form-group mt-3">
                            <button type="button" style="width: 100%" class="btn btn-primary" id="btnAcessarPainelAdmin">
                                Acessar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CDN Jquery -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- CDN SweetAlert JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Meus arquivos JS -->
    <script src="../app/view/js/funcs.js"></script>
    <script src="../app/view/js/login.js"></script>
</body>

</html>