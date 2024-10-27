<?= $this->extend('layouts/default') ?>    

<?= $this->section('content') ?>
<!--======================================================================================================================= -->
<!-- INTRODUCAO -->

<section class="home-container text-center d-flex flex-column align-items-center justify-content-center" id="introducao" style="min-height: 100vh; background-color: var(--cor-home);">
    <div class="content-home p-4">
        <h1 class="display-4" style="color: var(--cor-fonte-home);">Análise de Rede Wi-Fi Residencial</h1>
        <h3 class="mt-3" style="color: var(--cor-fonte-home2);">Mapeamento de Sinal Wi-Fi</h3>
        <h3 style="color: var(--cor-fonte-home2);">Velocidade da Rede</h3>
        <h3 style="color: var(--cor-fonte-home2);">Interferências</h3>
        <h3 style="color: var(--cor-fonte-home2);">Soluções Propostas</h3>
    </div>
</section>

<!--======================================================================================================================= -->
<!-- PLANTA -->

<section class="planta-container py-5 vh-100" id="planta" style="background-color: var(--cor-planta);">
    <div class="container">
        <h2 class="text-white mb-4 pt-4">Planta</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="planta-img-container mb-4">
                    <img src="<?= base_url('assets/img/planta.png') ?>" class="img-fluid rounded" alt="Planta da casa" style="height: 70vh; width: auto;">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end"> 
                <div class="text-container">
                    <p class="text-white">Passe o mouse sobre cada cômodo para visualizar as características da rede no local.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--======================================================================================================================= -->
<!-- ANALISE -->

<section class="analise-container text-white" id="analise" style="background-color: var(--cor-analise); min-height: 100vh; padding-top: 100px;">
    <div class="container">
        <h2 class="mb-4">Análise de Rede</h2>
    </div>
    <div class="container pt-5 mt-3">

        <form id="filtro_analise" class="mb-4" method="post" accept-charset="utf-8">
            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-4 px-1">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text">Cômodo</span>
                        <input type="text" class="form-control" name="filtroComodo" id="filtroComodo" maxlength="125">
                    </div>
                </div>
                <div class="col-auto px-1">
                    <button class="btn btn-danger shadow-sm py-1 px-2" id="filter">
                        <span class="material-symbols-rounded align-middle">filter_alt</span> Search
                    </button>
                </div>
                <div class="col-auto px-0">
                    <a class="btn btn-outline-danger shadow-sm py-1 px-2 tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Limpar Filtros" id="limpar">
                        <span class="material-symbols-rounded align-middle">filter_alt_off</span>
                    </a>
                </div>
            </div>   
        </form>

        <div class="row justify-content-center small">
            <div class="col-12 mb-5 p-3 table-responsive bg-dark">
                <table id="client_list" class="table table-hover table-md align-middle">
                    <thead class="bg-primary bg-opacity-10">
                        <tr>
                            <!-- <th scope="col" class="align-middle col"><span class="collapsed material-symbols-rounded p-0 m-0 btn text-start" id="toggleDetails">keyboard_double_arrow_down</span></th> -->

                            <th scope="col" class="col">Comodo</th> <!-- Nome do cômodo -->
                            <th scope="col" class="col">Rede</th> <!-- Nome (alias) da rede -->
                            <th scope="col" class="col">Frequência</th> <!-- Frequencia da Rede (2.4 / 5Ghz) -->
                            <th scope="col" class="col">Velocidade</th> <!-- Velocidade da Rede na medição -->
                            <th scope="col" class="col">Sinal</th> <!-- dBm -->
                            <th scope="col" class="col">Interferência</th>
                            <th scope="col" class="col">Data da Análise</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endsection() ?>