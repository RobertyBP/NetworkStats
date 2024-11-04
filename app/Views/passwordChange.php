<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>

<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

    <div class="container pt-5 mt-5 text-center text-white">
        <h1 class="p-0 m-0 mt-5 fw-bolder">Alteração de Senha</h1>
    </div>

    <div class="container pt-5 mt-5">
        <form id="changePassword">
            <div class="row justify-content-center pb-2 align-items-center">
                <div class="col-6 px-1 pb-2">
                    <label for="currentPassword" class="form-label px-1 text-white">Senha Atual</label>
                    <input type="password" class="form-control" id="senhaAtual" name="senhaAtual" placeholder="Digite sua senha atual" minlength="8" maxlength="256">
                </div>
            </div>

            <div class="row justify-content-center pb-2 align-items-center">
                <div class="col-6 px-1 pb-2">
                    <label for="novaSenha" class="form-label px-1 text-white">Nova Senha</label>
                    <input type="password" class="form-control" id="novaSenha" name="novaSenha" placeholder="Digite sua nova senha" minlength="8" maxlength="256">
                </div>
            </div>

            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-6 px-1 pb-2">
                    <label for="confirmaSenha" class="form-label px-1 text-white">Confirme sua Senha</label>
                    <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" placeholder="Confirme sua nova senha" minlength="8" maxlength="256">
                </div>
            </div>

            <div class="row justify-content-center pb-3 pt-4 align-items-center">
                <div class="col-6 px-1 pb-2">
                    <button class="btn btn-primary shadow-sm w-100" id="salvar">Salvar</button>
                </div>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>

<!-- *********************************************** -->
<!-- *********************************************** -->

<?= $this->section('more-scripts') ?>
<script src="<?= base_url("/assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url("/assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
<script type="text/javascript">

    $(document).ready(function () {
        // Form fields validation
        validator = $('#changePassword').validate({
            onfocusout: false,  // Desativa a revalidação do campo no foco alterado.
            onkeyup: false,     // Desativa a revalidação do campo ao escrever.
            onclick: false,     // Desativa a revalidação do campo no click.
            rules: {
                senhaAtual: {
                    required: true,
                    maxlength: 256,
                    nowhitespace: true,
                },
                novaSenha: {
                    required: true,
                    minlength: 8,
                    maxlength: 256,
                    nowhitespace: true,
                },
                confirmaSenha: {
                    required: true,
                    maxlength: 256,
                    equalTo: "#novaSenha",
                },
            },
            messages: {
                senhaAtual: {
                    required: "A senha atual é obrigatória.",
                    maxlength: "A senha atual e muito longa.",
                    nowhitespace: "Sua senha atual não pode conter espaços.",
                },
                novaSenha: {
                    required: "Por favor, insira sua nova senha.",
                    minlength: "Sua nova senha é muito curta.",
                    maxlength: "Sua nova senha é muito longa.",
                    nowhitespace: "A nova senha não pode conter espaços.",
                },
                confirmaSenha: {
                    required: "A confirmação da sua nova senha é obrigatória.",
                    equalTo: "A sua nova senha e a confirmação da mesma devem ser idênticas.",
                },
            },
            invalidHandler: function(e,validator) {
                // Construção do bloco de mensagem de erro baseado nos erros retornados:
                var errorMsg = "<ul>";
                // validator.errorList contains an array of objects, where each object has properties "element" and "message".  element is the actual HTML Input.
                for (var i = 0; i < validator.errorList.length; i++){
                    errorMsg += "<li>" + validator.errorList[i].message + "</li>";
                }
                errorMsg += "</ul>";
                mostrarMensagem('error', errorMsg);
            },
            errorPlacement: function (error, element) {},
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // Se a validação passar, envia o formulário.
                var formData = {
                    senhaAtual: $('#senhaAtual').val(),
                    novaSenha: $('#novaSenha').val(),
                    confirmaSenha: $('#confirmaSenha').val(),
                };

                var url = "<?= base_url('user/account/') . session('uuid') ?>/changePassword";

                $('#salvar').attr('disabled', 'disabled');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: JSON.stringify(formData),
                    contentType: "application/json; charset=utf-8",
                    success: function(response) {
                        if (response.status === 'error') {
                            mostrarMensagem('danger', response.message);
                        } else {
                            startCountdown(5, 'Sua senha foi atualizada. Redirecionamento em ');
                        }
                    },
                    error: function(response) {
                        mostrarMensagem('danger', response.message);
                    },
                });
            }
        });
    });

     // Countdown function
     function startCountdown(seconds, message) {
        var counter = seconds;
        var interval = setInterval(function() {
            if (counter > 0) {
                // Atualiza a mensagem com os segundos restantes
                mostrarMensagem('success', message + counter + '...');
                counter--;
            } else {
                clearInterval(interval); // Para o counter depois de 5 segundos.
                window.location.href = "<?= base_url('home') ?>"; // Redireciona o usuário para a página inicial.
            }
        }, 1000); // Intervalo de 1 segundo
    }

    $('#salvar').click(function () {
        event.preventDefault();
        $('#changePassword').submit(); // Form submit -> Acionamento da validação
    });

</script>

<?= $this->endsection() ?>
