<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.3-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <title>Login</title>
</head>


<body>
    
    <main class="d-flex align-items-center justify-content-center min-vh-100" style="background-image: url(<?= base_url('assets/img/login.jpeg') ?>); background-position: center; background-size: cover;">
        <section class="login-container">
            <div class="login-box">
                <h2 class="text-center mb-4 text-white">Acesse sua Conta</h2>
                <form class="login-text" action="<?= base_url('login') ?>" method="POST">
                    <div class="mb-3 text-white">
                        <input class="form-control bg-transparent text-white border-light" type="email" name="email" id="email" placeholder="E-mail" required maxlength="125">
                    </div>
                    <div class="mb-3 text-white">
                        <input class="form-control bg-transparent text-white border-light" type="password" name="senha" id="senha" placeholder="Senha" required maxlength="256">
                    </div>
                    <button class="btn btn-warning w-100" type="submit">Entrar</button>  
                </form>
            </div>
            <?= !empty($msg) ? "<div class='alert alert-danger small text-center p-2' role='alert'>$msg</div>" : "" ?>
        </section>
    </main>

</body>

</html>
