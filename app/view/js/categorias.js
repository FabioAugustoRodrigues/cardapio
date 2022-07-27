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
                "<td>" + nome + "</td>" +
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

function listar() {
    let formData = new FormData();
    formData.append("route", "listar-categorias");
    ajaxDinamico("POST", formData,
        function(response) {
            let botoesHtml = "<button class='btn btn-primary editarCategoria mx-1'>Editar</button>";

            for (let i = 0; i < response.length; i++) {
                $("#categoriasCadastradas > tbody").append(
                    "<tr id_categoria='" + response[i]["id"] + "'>" +
                    "<td>" + response[i]["nome"] + "</td>" +
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

})