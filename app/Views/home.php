<?= $this->extend('layouts/default') ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

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
                        <label for="filtroRede" class="input-group-text">Rede</label>
                        <select class="form-select" id="filtroRede" name="filtroRede">
                            <option selected value="0">Selecione...</option>
                            <?php foreach ($redes as $rede) : ?>
                                <option value="<?= $rede['cod_rede'] ?>"><?= $rede['rede'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-4 px-1">
                    <div class="input-group shadow-sm">
                        <label for="filtroComodo" class="input-group-text">Cômodo</label>
                        <select class="form-select" id="filtroComodo" name="filtroComodo">
                            <option selected value="0">Selecione...</option>
                            <?php foreach ($comodos as $comodo) : ?>
                                <option value="<?= $comodo['cod_comodo'] ?>"><?= $comodo['comodo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-auto px-1">
                    <div class="input-group shadow-sm">
                        <label for="filtroFrequencia" class="input-group-text">Frequência</label>
                        <select class="form-select" id="filtroFrequencia" name="filtroFrequencia">
                            <option selected value="0">Selecione...</option>
                            <option value="2.4Ghz">2.4Ghz</option>
                            <option value="5Ghz">5Ghz</option>
                        </select>
                    </div>
                </div>
                <div class="col-auto px-1">
                    <button class="btn btn-primary shadow-sm py-1 px-2" id="filtrar">
                        <span class="material-symbols-rounded align-middle">filter_alt</span> Filtrar
                    </button>
                </div>
                <div class="col-auto px-0">
                    <a class="btn btn-outline-primary shadow-sm py-1 px-2 tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Limpar Filtros" id="limpar">
                        <span class="material-symbols-rounded align-middle">filter_alt_off</span>
                    </a>
                </div>
            </div>
        </form>

        <div class="row justify-content-center small">
            <div class="col-12 mb-5 p-3 table-responsive text-white">
                <table id="listar_analise" class="table table-hover table-striped table-sm align-middle">
                    <thead style="background-color: #1E3E62;">
                        <tr>
                            <th scope="col" class="col text-white">Cômodo</th>
                            <th scope="col" class="col text-white">Rede</th>
                            <th scope="col" class="col text-white">Frequência</th>
                            <th scope="col" class="col text-white">Velocidade</th>
                            <th scope="col" class="col text-white">dBm</th>
                            <th scope="col" class="col text-white">Interferência</th>
                            <th scope="col" class="col text-white">Data da Análise</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</section>
<?= $this->endsection() ?>
<!-- *********************************************** -->
<!-- *********************************************** -->
<?= $this->section('more-scripts') ?>

<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/buttons.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url("/assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
<script src="<?= base_url("/assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
<script src="<?= base_url("/assets/js/validation_messages.js") ?>"></script>
<script type="text/javascript">

DataTable.Buttons.defaults.dom.button.className = 'btn'; // Sobrescreve a estilização padrão do datatables sobre os botões

    var table = new DataTable('#listar_analise', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url("analise/list/json") ?>",
            type: "POST",
            data: function(d) {
                d.filtroRede = $("#filtroRede").val();
                d.filtroComodo = $("#filtroComodo").val();
                d.filtroFrequencia = $("#filtroFrequencia").val();
            }
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        language:{url: '<?= base_url("assets/datatables-pt-BR.json") ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: {},
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'COMODO' },
            { data: 'REDE' },
            { data: 'FREQUENCIA' },
            { data: 'VELOCIDADE' },
            { data: 'NIVEL_SINAL' },
            { data: 'INTERFERENCIA' },
            { data: 'DT_ANALISE' },
        ],

    } );

    // Carregamento de Tooltip ao iniciar o DataTables
    table.on('draw.dt', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    $('#filtrar').on('click', function(event) {
        event.preventDefault();
        table.ajax.reload();
    });

    // Limpar os filtros do datatables
    $('#limpar').on('click', function(){
        $('#filtro_analise')[0].reset();
        table.ajax.reload(); // Table reload
    });


</script>

<?= $this->endsection() ?>