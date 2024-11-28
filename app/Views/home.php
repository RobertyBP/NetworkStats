<?= $this->extend('layouts/default') ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!--======================================================================================================================= -->
<!-- INTRODUÇÃO -->

<section class="home-container py-5 text-center d-flex flex-column align-items-center justify-content-center vh-100" id="introducao" style="min-height: 100vh; background-color: var(--cor-home);">
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
    <div class="container mt-5">
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
<!-- ANÁLISE -->
 
<section class="analise-container text-white" id="analise" style="background-color: var(--cor-analise); min-height: 100vh; padding-top: 100px;">
    <div class="container mt-5">
        <h2 class="mb-4">Análise de Rede</h2>
    </div>
    <div class="container pt-5 mt-3">
        <form id="filtro_analise" class="mb-4" method="post" accept-charset="utf-8">
            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-md-3">
                    <label for="filtroRede" class="form-label">Rede</label>
                    <select class="form-select" id="filtroRede" name="filtroRede">
                        <option selected value="0">Selecione...</option>
                        <?php foreach ($redes as $rede) : ?>
                            <option value="<?= $rede['cod_rede'] ?>"><?= $rede['rede'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroComodo" class="form-label">Cômodo</label>
                    <select class="form-select" id="filtroComodo" name="filtroComodo">
                        <option selected value="0">Selecione...</option>
                        <?php foreach ($comodos as $comodo) : ?>
                            <option value="<?= $comodo['cod_comodo'] ?>"><?= $comodo['comodo'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filtroFrequencia" class="form-label">Frequência</label>
                    <select class="form-select" id="filtroFrequencia" name="filtroFrequencia">
                        <option selected value="0">Selecione...</option>
                        <option value="2.4Ghz">2.4Ghz</option>
                        <option value="5Ghz">5Ghz</option>
                    </select>
                </div>
                <div class="col-md-auto mt-auto">
                    <button class="btn btn-primary shadow-sm py-1 px-3" id="filtrar">
                        <span class="material-symbols-rounded align-middle">filter_alt</span> Filtrar
                    </button>
                </div>
                <div class="col-md-auto px-0 mt-auto">
                    <a class="btn btn-outline-primary shadow-sm py-1 px-3 tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Limpar Filtros" id="limpar">
                        <span class="material-symbols-rounded align-middle">filter_alt_off</span>
                    </a>
                </div>
            </div>
        </form>

        <div class="row justify-content-center small">
            <div class="col-12 mb-5 p-3 table-responsive text-white">
                <table id="listar_analise" class="table table-hover table-striped table-md align-middle">
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

        <!-- DASHBOARDS -->
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="chartVelocidade"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="chartMediaVelocidade"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="chartNivelSinal"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <canvas id="chartInterferencia"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!--======================================================================================================================= -->

<?= $this->endSection() ?>

<!-- *********************************************** -->
<!-- *********************************************** -->
<?= $this->section('more-scripts') ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    });

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

    // Gráfico de Velocidade de Internet
    const ctxVelocidade = document.getElementById('chartVelocidade').getContext('2d');
    const chartVelocidade = new Chart(ctxVelocidade, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Velocidade (Mbps)',
                data: [],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Gráfico de Média de Velocidade (2.4Ghz e 5Ghz por cômodo)
    const ctxMediaVelocidade = document.getElementById('chartMediaVelocidade').getContext('2d');
    const chartMediaVelocidade = new Chart(ctxMediaVelocidade, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Média de Velocidade (Mbps)',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Gráfico de Níveis de Sinal
    const ctxNivelSinal = document.getElementById('chartNivelSinal').getContext('2d');
    const chartNivelSinal = new Chart(ctxNivelSinal, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Nível de Sinal (dBm)',
                data: [],
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Gráfico de Interferências - Quantidade de Interferências por Cômodo
    const ctxInterferencia = document.getElementById('chartInterferencia').getContext('2d');
    const chartInterferencia = new Chart(ctxInterferencia, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Interferências',
                data: [],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const datasetIndex = tooltipItem.datasetIndex;
                            const dataIndex = tooltipItem.dataIndex;
                            const interferencias = tooltipItem.chart.data.datasets[datasetIndex].data[dataIndex];
                            
                            // Exibe a quantidade de interferências (número)
                            return `Quantidade de Interferências: ${interferencias}`;
                        }
                    }
                }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Atualizar gráficos quando a tabela for desenhada
    table.on('draw', function () {
        const data = table.rows({ search: 'applied' }).data();

        // Atualizar gráfico de Velocidade
        const labelsVelocidade = [];
        const valuesVelocidade = [];
        const labelsMedia = [];
        const valuesMedia = [];
        const labelsSinal = [];
        const valuesSinal = [];
        const labelsInterferencia = [];
        const valuesInterferencia = [];

        // Variável para calcular média das velocidades de 2.4 e 5Ghz por cômodo
        const comodosVelocidade = {};

        for (let i = 0; i < data.length; i++) {
            const comodo = data[i].COMODO;
            const frequencia = data[i].FREQUENCIA;
            const velocidade = parseFloat(data[i].VELOCIDADE);
            const nivelSinal = parseFloat(data[i].NIVEL_SINAL);
            const interferencias = data[i].INTERFERENCIA;

            // Adiciona dados para gráfico de Velocidade (considera a frequência)
            labelsVelocidade.push(`${comodo} (${frequencia})`);
            valuesVelocidade.push(velocidade);

            // Média de Velocidade (2.4Ghz + 5Ghz para cada cômodo)
            if (!comodosVelocidade[comodo]) {
                comodosVelocidade[comodo] = { total: 0, count: 0 };
            }
            comodosVelocidade[comodo].total += velocidade;
            comodosVelocidade[comodo].count++;

            // Nível de Sinal (considera a frequência)
            labelsSinal.push(`${comodo} (${frequencia})`);
            valuesSinal.push(nivelSinal);

            // Interferência
            // Se a interferência não for "N/A", contar como interferência
            if (interferencias !== "N/A") {
                const interferenciaCount = interferencias.split(',').length;
                labelsInterferencia.push(`${comodo} (${frequencia})`);
                valuesInterferencia.push(interferenciaCount);
            } else {
                // Se for "N/A", tratar como 0 interferência
                labelsInterferencia.push(`${comodo} (${frequencia})`);
                valuesInterferencia.push(0);
            }
        }

        // Calcular e atualizar a média de velocidade por cômodo
        Object.keys(comodosVelocidade).forEach(comodo => {
            const mediaVelocidade = comodosVelocidade[comodo].total / comodosVelocidade[comodo].count;
            labelsMedia.push(comodo);
            valuesMedia.push(mediaVelocidade);
        });

        // Atualizar gráfico de Velocidade
        chartVelocidade.data.labels = labelsVelocidade;
        chartVelocidade.data.datasets[0].data = valuesVelocidade;
        chartVelocidade.update();

        // Atualizar gráfico de Média de Velocidade
        chartMediaVelocidade.data.labels = labelsMedia;
        chartMediaVelocidade.data.datasets[0].data = valuesMedia;
        chartMediaVelocidade.update();

        // Atualizar gráfico de Nível de Sinal
        chartNivelSinal.data.labels = labelsSinal;
        chartNivelSinal.data.datasets[0].data = valuesSinal;
        chartNivelSinal.update();

        // Atualizar gráfico de Interferências (quantidade)
        chartInterferencia.data.labels = labelsInterferencia;
        chartInterferencia.data.datasets[0].data = valuesInterferencia;
        chartInterferencia.update();
    });

    // Filtrar e carregar os gráficos com os filtros
    $('#filtrar').click(() => table.ajax.reload());
    $('#limpar').click(() => { $('#filtro_analise')[0].reset(); table.ajax.reload(); });
</script>

<?= $this->endSection() ?>