function ajaxDinamico(tipo, dados, sucesso, erro) {
    $.ajax({
        url: "/cardapio/app/controller/http/controller.php",
        type: tipo,
        data: dados,
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
            sucesso(response);
        },
        error: function(response) {
            erro(response);
        }
    });
}