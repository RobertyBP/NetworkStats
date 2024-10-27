<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container py-5 my-5 text-secondary">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <h2 class="mb-5 mt-5">
                Bem-vindo(a) <?= session('nome') ?>!
            </h2>
            <p>
                O <strong>Projeto WIFI</strong> tem como objetivo atender aos requisitos propostos como critério de avaliação para a disciplina de Desenvolvimento de Projeto 1.
            </p>
            <p> 
                O sistema visa prover uma fácil visualização das medidas de velocidade da rede WiFi para um cliente específico. O atual projeto também oferece um overview quanto ao nível de sinal, interferência e qualidade da rede analisada.
            </p>
            <br><br><br>
            <p>Projeto desenvolvido por:
            <br>Denner Ribas Amaral - <strong>2163241</strong>
            <br>Eduardo Gomes dos Santos - <strong>2164418</strong>
            <br>Rayane Carmelia Custodio - <strong>2164418</strong>
            <br>Roberty Brum Pereira - <strong>2162636</strong>
            <br>Vitor Iago Huggler - <strong>2384329</strong>
        </div>
    </div>
</div>
<?= $this->endSection() ?>