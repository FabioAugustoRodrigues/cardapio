function criar(nome, descricao) {
    let formData = new FormData();
    formData.append("route", "criar-categoria");
    formData.append("nome", nome);
    formData.append("descricao", descricao);
    ajaxDinamico("POST", formData,
        function(response) {
            let botoesHtml = "<button class='btn btn-primary editarCategoria mx-1'>Editar</button>";

            $("#categoriasCadastradas > tbody").append(
                "<tr id_categoria='" + response["id"] + "'>" +
                "<td class='nomeDaCategoria'>" + nome + "</td>" +
                "<td>" + botoesHtml + "</td>" +
                "</tr>"
            );

            $("#modalCadastrarCategoria").modal("hide");

            $("#cadastrarNomeCategoria").val("");
            $("#cadastrarDescricaoCategoria").val("");

            swal("Categoria cadastrada com sucesso!", "", "success");
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");

            $("#cadastrarNomeCategoria").val("");
            $("#cadastrarDescricaoCategoria").val("");
        }
    );
}

function editar(id, nome, descricao) {
    let formData = new FormData();
    formData.append("route", "editar-categoria");
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("descricao", descricao);
    ajaxDinamico("POST", formData,
        function(response) {
            $("tr[id_categoria='" + id + "'] td.nomeDaCategoria").text(nome);

            $("#modalEditarCategoria").modal("hide");

            $("#editarNomeCategoria").val("");
            $("#editarDescricaoCategoria").val("");

            swal(response[0], "", "success");
        },
        function(response) {
            console.log(response);
            swal(response.responseJSON[0], "", "error");

            $("#cadastrarNomeCategoria").val("");
            $("#cadastrarDescricaoCategoria").val("");
        }
    );
}

function listar() {
    let formData = new FormData();
    formData.append("route", "listar-categorias");
    ajaxDinamico("POST", formData,
        function(response) {
            let botoesHtml = "<button class='btn btn-primary editarCategoria mx-1'>Editar</button>";

            for (let i = 0; i < response.length; i++) {
                $("#categoriasCadastradas > tbody").append(
                    "<tr id_categoria='" + response[i]["id"] + "'>" +
                    "<td class='nomeDaCategoria'>" + response[i]["nome"] + "</td>" +
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

function lerPorId(id) {
    let formData = new FormData();
    formData.append("route", "ler-categoria-por-id");
    formData.append("id", id);
    ajaxDinamico("POST", formData,
        function(response) {
            if (response == null) {
                swal("Categoria não encontrada", "", "warning");
            } else {
                $("#idDaCategoriaSelecionada").val(response["id"]);
                $("#editarNomeCategoria").val(response["nome"]);
                $("#editarDescricaoCategoria").val(response["descricao"]);

                $("#modalEditarCategoria").modal("show");
            }
        },
        function(response) {
            console.log(response);
            swal(response.responseJSON[0], "", "error");
        }
    );
}


$(document).ready(function() {

    $("#abrirModalCadastrarCategoria").on("click", function() {
        $("#modalCadastrarCategoria").modal("show");
    });

    $("#salvarCategoria").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#formularioCadastrarCategoria")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            criar($("#cadastrarNomeCategoria").val(), $("#cadastrarDescricaoCategoria").val());
            $("#formularioCadastrarCategoria").removeClass("was-validated");
        }
    });

    $(document).on("click", ".editarCategoria", function() {
        let id = $(this).parents("tr").attr("id_categoria");
        lerPorId(id);
    });

    $("#editarCategoria").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#formularioEditarCategoria")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            editar($("#idDaCategoriaSelecionada").val(), $("#editarNomeCategoria").val(), $("#editarDescricaoCategoria").val());
            $("#formularioEditarCategoria").removeClass("was-validated");
        }
    });

});