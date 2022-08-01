function criar(nome, preco, id_categoria) {
    let formData = new FormData();
    formData.append("route", "criar-produto");
    formData.append("nome", nome);
    formData.append("preco", preco);
    formData.append("id_categoria", id_categoria);
    ajaxDinamico("POST", formData,
        function(response) {
            let botoesHtml = "<button class='btn btn-primary editarProduto mx-1'>Editar</button>";

            $("#produtosCadastrados > tbody").append(
                "<tr id_produto='" + response["id"] + "'>" +
                "<td class='nomeDoProduto'>" + nome + "</td>" +
                "<td>" + botoesHtml + "</td>" +
                "</tr>"
            );

            $("#modalCadastrarProduto").modal("hide");

            $("#cadastrarNomeProduto").val("");
            $("#cadastrarDescricaoProduto").val("");

            swal("Produto cadastrado com sucesso!", "", "success");
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");

            $("#cadastrarNomeProduto").val("");
            $("#cadastrarPrecoProduto").val("");
        }
    );
}

function editar(id, nome, preco, id_categoria) {
    console.log(id_categoria);
    let formData = new FormData();
    formData.append("route", "editar-produto");
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("preco", preco);
    formData.append("id_categoria", id_categoria);
    ajaxDinamico("POST", formData,
        function(response) {
            $("tr[id_produto='" + id + "'] td.nomeDoProduto").text(nome);

            $("#modalEditarProduto").modal("hide");

            $("#editarNomeProduto").val("");
            $("#editarPrecoProduto").val("");

            swal(response[0], "", "success");
        },
        function(response) {
            console.log(response);
            swal(response.responseJSON[0], "", "error");

            $("#editarNomeProduto").val("");
            $("#editarPrecoProduto").val("");
        }
    );
}

function listar() {
    let formData = new FormData();
    formData.append("route", "listar-produtos");
    ajaxDinamico("POST", formData,
        function(response) {
            console.log(response);
            let botoesHtml = "<button class='btn btn-primary editarProduto mx-1'>Editar</button>";

            for (let i = 0; i < response.length; i++) {
                $("#produtosCadastrados > tbody").append(
                    "<tr id_produto='" + response[i]["id"] + "'>" +
                    "<td class='nomeDoProduto'>" + response[i]["nome"] + "</td>" +
                    "<td>" + botoesHtml + "</td>" +
                    "</tr>"
                );
            }
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");
        }
    );
}

function listarCategorias() {
    let formData = new FormData();
    formData.append("route", "listar-categorias");
    ajaxDinamico("POST", formData,
        function(response) {
            for (let i = 0; i < response.length; i++) {
                console.log(response[i]['id']);
                $(".categoriasEncontradas").append(
                    "<option id_categoria='" + response[i]["id"] + "'>" + response[i]["nome"] + "</option>"
                );
            }
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");
        }
    );
}


function lerPorId(id) {
    let formData = new FormData();
    formData.append("route", "ler-produto-por-id");
    formData.append("id", id);
    ajaxDinamico("POST", formData,
        function(response) {
            if (response == null) {
                swal("Produto não encontrado", "", "warning");
            } else {
                $("#idDoProdutoSelecionado").val(response["produto"]["id"]);
                $("#editarNomeProduto").val(response["produto"]["nome"]);
                $("#editarPrecoProduto").val(response["produto"]["preco"]);
                $("#editarCategoriaProduto").find("option[id_categoria='" + response["categoria"]["id"] + "']").attr('selected', 'selected');

                $("#modalEditarProduto").modal("show");
            }
        },
        function(response) {
            console.log(response);
            swal(response.responseJSON[0], "", "error");
        }
    );
}

$(document).ready(function() {

    $("#abrirModalCadastrarProduto").on("click", function() {
        $("#modalCadastrarProduto").modal("show");
    });

    $("#salvarProduto").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#formularioCadastrarProduto")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            criar($("#cadastrarNomeProduto").val(), $("#cadastrarPrecoProduto").val(), $("#cadastrarCategoriaProduto").find(":selected").attr("id_categoria"));
            $("#formularioCadastrarProduto").removeClass("was-validated");
        }
    });

    $(document).on("click", ".editarProduto", function() {
        let id = $(this).parents("tr").attr("id_produto");
        lerPorId(id);
    });

    $("#editarProduto").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#formularioEditarProduto")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            editar($("#idDoProdutoSelecionado").val(), $("#editarNomeProduto").val(), $("#editarPrecoProduto").val(), $("#editarCategoriaProduto").find(":selected").attr("id_categoria"));
            $("#formularioEditarProduto").removeClass("was-validated");
        }
    });

});;