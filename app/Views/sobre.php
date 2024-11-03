<?php
/**
 * @var CodeIgniter\View\View $this
*/
?>
<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container py-5 my-5 text-white">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <h2 class="mb-5 mt-5">
                Bem-vindo(a) <span style="color: var(--cor-fonte-home2)"><?= session('nome') ?></span>!
            </h2>
            <p>
                O <strong><span style="color: var(--cor-fonte-home2)">Projeto WIFI</span></strong> tem como objetivo atender aos requisitos propostos como critério de avaliação para a disciplina de Desenvolvimento de Projeto 1.
            </p>
            <p> 
                O sistema visa prover uma fácil visualização das medidas de velocidade da rede WiFi para um cliente específico. O atual projeto também oferece um overview quanto ao nível de sinal, interferência e qualidade da rede analisada.
            </p>
            <br><br><br>
            <p>Projeto desenvolvido por:
            <br>Denner Ribas Amaral - <strong><span style="color: var(--cor-fonte-home2)">2163241</span></strong>
            <br>Eduardo Gomes dos Santos - <strong><span style="color: var(--cor-fonte-home2)">2164418</span></strong>
            <br>Rayane Carmelia Custodio - <strong><span style="color: var(--cor-fonte-home2)">2164418</span></strong>
            <br>Roberty Brum Pereira - <strong><span style="color: var(--cor-fonte-home2)">2162636</span></strong>
            <br>Vitor Iago Huggler - <strong><span style="color: var(--cor-fonte-home2)">2384329</span></strong>
        </div>
    </div>
</div>
<?= $this->endSection() ?>