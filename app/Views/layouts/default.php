<!-- Header -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/material-symbols/material-symbols-rounded.css') ?>">

    <style>
        /* Toast Style Setup */
        .toast-custom {
            background-color: var(--toast-bg-color, #f8d7da); /* Background padrão */
            color: var(--toast-text-color, #842029); /* Texto padrão */
        }
        .toast-custom .toast-header {
            background-color: var(--toast-header-bg-color, #f8d7da); /* Background do header */
            color: var(--toast-header-text-color, #842029); /* Texto do header */
        }
        .toast-custom .toast-body {
            background-color: var(--toast-body-bg-color, #f8d7da); /* Background do corpo */
            color: var(--toast-body-text-color, #842029); /* Texto do corpo */
        }

    </style>
    <?= $this->renderSection('more-styles') ?>

    <title>Projeto WIFI</title>
</head>

<!-- Content -->
<body class="d-flex flex-column min-vh-100" style="background-color: var(--cor-home);">
<main class="flex-grow-1">

    <?php if(!isset($no_banner) || $no_banner == false) : ?>
    <nav class="navbar navbar-expand-lg fixed-top py-3" style="background-color: var(--cor-planta);" aria-label="primaria">
        <div class="container d-flex justify-content-between align-items-center">
            
            <a href="<?= base_url('home') ?>">
                <img src="<?= base_url('assets/img/wifi.svg') ?>" alt="Logo" width="32" height="32" />
            </a>

            <?php if (!isset($no_menu) || $no_menu == false): ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php endif ?>

            <div class="collapse navbar-collapse <?= isset($no_menu) && $no_menu == true ? 'flex-grow-0' : '' ?>" id="navbarContent">
                <?php if (!isset($no_menu) || $no_menu == false): ?>
                <ul class="nav mb-0">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('home#introducao') ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('home#planta') ?>">Planta</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('home#analise') ?>">Análise de rede</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('sobre') ?>">Sobre</a></li>
                </ul>
                <?php endif ?>
            </div>

            <div class="d-flex align-items-center mx-3 navbarContentClass">
                <span class="navbar-text text-white pe-3">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= session('is_admin') === true ? '<span class="material-symbols-rounded align-bottom text-white">shield_person</span> ' : '' ?>
                            <b class="text-white"><?= session('nome_reduzido') ?></b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="navbarDarkDropdownMenuLink">
                            <?php if(session('is_admin') === true) : ?>
                                <li><span class="dropdown-header">Administração</span></li>
                                <li><a href="<?= base_url('users/list') ?>" class="dropdown-item"><span class="material-symbols-rounded align-bottom">settings_account_box</span> Gestão de Usuários</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="mt-1"><a href="<?= base_url('redes/list') ?>" class="dropdown-item"><span class="material-symbols-rounded align-bottom">wifi</span> Gestão de Redes</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="mt-1"><a href="<?= base_url('comodos/list') ?>" class="dropdown-item"><span class="material-symbols-rounded align-bottom">house</span> Gestão de Cômodos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="mt-1"><a href="<?= base_url('sinais/list') ?>" class="dropdown-item"><span class="material-symbols-rounded align-bottom">signal_cellular_alt</span> Gestão de Sinais</a></li>
                                <li><hr class="dropdown-divider pt-1 pb-1"></li>
                            <?php endif ?>
                            <li><span class="dropdown-header">Conta</span></li>
                            <li><a href="<?= base_url('user/account/') . session('uuid') ?>/changePassword" class="dropdown-item"><span class="material-symbols-rounded align-bottom">passkey</span> Alterar minha senha</a></li>
                        </ul>
                    </div>
                </span>
                <a href="<?= base_url('logout') ?>" class="nav-link">
                    Sair <span class="material-symbols-rounded align-bottom">logout</span>
                </a>
            </div>

        </div>
    </nav>
    <?php endif ?>

    <?= $this->renderSection('content') ?>

    <!-- Alertas -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <div id="alerta" class="toast toast-custom" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="tituloAlerta">Notificação</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="alertaMensagem">
                <!-- Mensagem é exibida aqui -->
            </div>
        </div>
    </div>

</main>

<!-- Footer -->
<footer class="footer mt-auto" style="background-color: #000;">
    <div class="container d-flex justify-content-center align-items-center text-white small py-3">
        <a href="<?= base_url('home') ?>">
            <img src="<?= base_url('assets/img/wifi.svg') ?>" class="footer-icon" style="width: 30px; height: auto; margin-right: 10px;" alt="Logo">
        </a>
        <div class="text-center">
            <p class="m-0">&copy; Todos os direitos reservados.</p>
            <p class="m-0"><?= date('Y') ?> - Desenvolvimento de Projeto 1</p>
        </div>
    </div>
</footer>

<!--==========================================================================================================================================-->
<!--==========================================================================================================================================-->
<!--==========================================================================================================================================-->

<script src="<?= base_url('assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/JQuery-3.7.0/jquery-3.7.0.min.js') ?>"></script>
<script>
    
    function mostrarMensagem(tipo, mensagem) {
        var tituloAlerta = tipo === 'success' ? 'Sucesso' : 'Erro';
        var bgColor = tipo === 'success' ? '#d4edda' : '#f8d7da';
        var textColor = tipo === 'success' ? '#155724' : '#842029';

        $('#tituloAlerta').text(tituloAlerta);
        $('#alertaMensagem').html(mensagem); 
        $('#alerta').css({
            '--toast-bg-color': bgColor,
            '--toast-text-color': textColor,
            '--toast-header-bg-color': bgColor,
            '--toast-header-text-color': textColor,
            '--toast-body-bg-color': bgColor,
            '--toast-body-text-color': textColor
        }).toast({ delay: 5000, html: true }).toast('show');
    }

    // Inicialização do Toast
    $(document).ready(function(){
        $('.toast').toast({ animation: true, autohide: true, delay: 5000 });
    });

    // Bootstrap Tooltips:
    $(document).ready(function () {
        const tooltips = document.querySelectorAll('.tt'); // Seleciona todos os elementos com a classe .tt
        tooltips.forEach(t => {
            new bootstrap.Tooltip(t); // Inicializa o tooltip para cada elemento
        });
    });

</script>

<?= $this->renderSection('more-scripts') ?>

</body>

</html>



