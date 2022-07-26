function login(nome, senha) {
    let formData = new FormData();
    formData.append("route", "login-admin");
    formData.append("nome", nome);
    formData.append("senha", senha);
    ajaxDinamico("POST", formData,
        function(response) {
            // aqui nós podemos optar por mostrar uma mensagem de sucesso
            // swal(response[0], "", "success");

            window.location = "/cardapio/catalogo/";
        },
        function(response) {
            swal(response.responseJSON[0], "", "error");

            $("#senha").val("");
        }
    );
}

$(document).ready(function() {

    $("#btnAcessarPainelAdmin").on("click", function() {
        let formularioEstaValido = true;
        let form = $("#loginPainelAdmin")[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            formularioEstaValido = false;
        }

        if (formularioEstaValido) {
            login($("#nome").val(), $("#senha").val());
        }
    });

})