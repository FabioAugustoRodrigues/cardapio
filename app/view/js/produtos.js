function criar(nome, preco, id_categoria) {
    let file_data = $("#cadastrarImagemProduto").prop("files")[0];

    let formData = new FormData();
    formData.append("route", "criar-produto");
    formData.append("nome", nome);
    formData.append("preco", preco);
    formData.append("id_categoria", id_categoria);
    formData.append("file", file_data == undefined ? null : file_data);

    ajaxDinamico("POST", formData,
        function(response) {
            let botoesHtml = "<button class = 'btn btn-primary editarProduto mx-1'>Editar</button><button class='btn btn-danger excluirProduto mx-1'>Excluir</button>";

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
            console.log(response);
            swal(response.responseJSON[0], "", "error");

            $("#cadastrarNomeProduto").val("");
            $("#cadastrarPrecoProduto").val("");
        }
    );
}

function editar(id, nome, preco, situacao, id_categoria) {
    let file_data = $("#editarImagemProduto").prop("files")[0];

    let formData = new FormData();
    formData.append("route", "editar-produto");
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("preco", preco);
    formData.append("situacao", situacao);
    formData.append("id_categoria", id_categoria);
    formData.append("file", file_data == undefined ? null : file_data);

    ajaxDinamico("POST", formData,
        function(response) {
            $("tr[id_produto='" + id + "'] td.nomeDoProduto").text(nome);

            if ($("#editarSituacaoProduto").val() == "Desabilitado") {
                $("tr[id_produto='" + id + "']").addClass("table-danger");
            } else {
                $("tr[id_produto='" + id + "']").removeClass("table-danger");
            }

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
            let botoesHtml = "<button class = 'btn btn-primary editarProduto mx-1'>Editar</button><button class='btn btn-danger excluirProduto mx-1'>Excluir</button>";

            for (let i = 0; i < response.length; i++) {
                let classesTabelaHtml = "";
                if (response[i]["situacao"] == "Desabilitado") {
                    classesTabelaHtml += " table-danger";
                }

                $("#produtosCadastrados > tbody").append(
                    "<tr class='" + classesTabelaHtml + "' id_produto='" + response[i]["id"] + "'>" +
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
                $("#editarPrecoProduto").val(response["produto"]["preco"].replace(".", ","));
                $("#editarSituacaoProduto").val(response["produto"]["situacao"]);
                $("#editarCategoriaProduto").find("option[id_categoria='" + response["categoria"]["id"] + "']").attr('selected', 'selected');

                $("#modalEditarProduto").modal("show");
            }
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");
        }
    );
}

function excluir(id) {
    let formData = new FormData();
    formData.append("route", "excluir-produto");
    formData.append("id", id);
    ajaxDinamico("POST", formData,
        function(response) {
            $("tr[id_produto='" + id + "']").remove();

            swal(response[0], "", "success");
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");
        }
    );
}

function listarProdutosPorCategoria() {
    let formData = new FormData();
    formData.append("route", "listar-catalogo");
    ajaxDinamico("POST", formData,
        function(response) {
            for (const categoria in response) {
                $("#catalogo").append(
                    "<div class='w-100 row mb-3' id='categoria" + categoria + "'>" +
                    "<h3>" + categoria + "</h3>" +
                    "</div>"
                );

                for (let i = 0; i < response[categoria].length; i++) {
                    let preco = response[categoria][i]["preco"];
                    preco = preco.replaceAll(".", ",");

                    $("#categoria" + categoria).append(
                        "<div class='card col-sm-12 col-md-12 mb-2 produtoEncontrado'>" +
                        "<div class='card-body row'>" +
                        "<div class='col-sm-12 col-md-1'>" +
                        "<img src='../documentos/fotos/" + response[categoria][i]["foto"] + "' class='rounded w-100'>" +
                        "</div>" +
                        "<div class='col-sm-12 col-md-11'>" +
                        "<h5 class='card-title'>" + response[categoria][i]["nome"] + "</h5>" +
                        "<h6>R$ " + preco + "</h6>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );
                }
            }
        },
        function(response) {
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

    $(document).on("click", ".excluirProduto", function() {
        let id = $(this).parents("tr").attr("id_produto");
        let nome = $(this).parents("tr td.nomeDoProduto").text();
        console.log(nome);

        swal({
                title: "Atenção!",
                text: "Deseja deletar o produto " + nome,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((iraDeletar) => {
                if (iraDeletar) {
                    excluir(id);
                }
            });
    });

    $("#editarProduto").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#formularioEditarProduto")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            editar($("#idDoProdutoSelecionado").val(), $("#editarNomeProduto").val(), $("#editarPrecoProduto").val(), $("#editarSituacaoProduto").val(), $("#editarCategoriaProduto").find(":selected").attr("id_categoria"));
            $("#formularioEditarProduto").removeClass("was-validated");
        }
    });
});