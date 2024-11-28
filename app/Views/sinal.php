<?= $this->extend('layouts/default') ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="container pt-5 mt-5 text-center text-white">
        <h1 class="p-0 m-0 mt-5 fw-bolder">Gestão de Sinais</h1>
    </div>

    <div class="container pt-5 mt-3">
        <form id="busca_sinal" class="mb-4" method="post" accept-charset="utf-8">
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
                <div class="col-3 px-1">
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

        <!-- Modal Form -->
        <div class="modal fade" id="sinalModal" tabindex="-1" role="dialog" aria-labelledby="sinalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="sinalModalLabel"></h5>
                    </div>
                    <div class="modal-body bg-light">
                        <form id="sinal_form">
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-4 px-1">
                                    <div class="input-group shadow-sm">
                                        <label for="rede" class="input-group-text">Rede</label>
                                        <select class="form-select" id="rede" name="rede">
                                            <option selected value="0">Selecione...</option>
                                            <?php foreach ($redes as $rede) : ?>
                                                <option value="<?= $rede['cod_rede'] ?>"><?= $rede['rede'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="input-group shadow-sm">
                                        <label for="frequencia" class="input-group-text">Frequência</label>
                                        <select class="form-select" id="frequencia" name="frequencia">
                                            <option selected value="0">Selecione...</option>
                                            <option value="2.4Ghz">2.4Ghz</option>
                                            <option value="5Ghz">5Ghz</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-4 px-1">
                                    <div class="input-group shadow-sm">
                                        <label for="comodo" class="input-group-text">Cômodo</label>
                                        <select class="form-select" id="comodo" name="comodo">
                                            <option selected value="0">Selecione...</option>
                                            <?php foreach ($comodos as $comodo) : ?>
                                                <option value="<?= $comodo['cod_comodo'] ?>"><?= $comodo['comodo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">Velocidade</span>
                                        <input type="text" class="form-control" name="velocidade" id="velocidade" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-2 px-1">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">dBm</span>
                                        <input type="text" class="form-control" name="dbm" id="dbm" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-5 px-1">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">Interferência</span>
                                        <input type="text" class="form-control" name="interferencia" id="interferencia" maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-primary" id="cancelar" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="salvar">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir este sinal?</p>
                        <p>Todos os dados relacionados a este sinal serão <strong>permanentemente</strong> excluídos.</p>
                        <p>Essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center small">
            <div class="col-12 mb-5 p-3 table-responsive text-white">
                <table id="listar_sinais" class="table table-hover table-striped table-sm align-middle">
                    <thead style="background-color: #1E3E62;">
                        <tr>
                            <th scope="col" class="col text-white">COD_SINAL</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">COD_COMODO</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">COD_REDE</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">Cômodo</th>
                            <th scope="col" class="col text-white">Rede</th>
                            <th scope="col" class="col text-white">Frequência</th>
                            <th scope="col" class="col text-white">Velocidade</th>
                            <th scope="col" class="col text-white">dBm</th>
                            <th scope="col" class="col text-white">Interferência</th>
                            <th scope="col" class="col text-white">Dt. Análise</th>
                            <th scope="col" class="col-2 text-white">Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
<?= $this->endSection() ?>

<!-- *********************************************** -->
<!-- *********************************************** -->

<?= $this->section('more-scripts') ?>

    <script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/DataTables-2.0.3/js/dataTables.bootstrap5.min.js') ?>"></script>
    <script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/js/buttons.bootstrap5.min.js') ?>"></script>
    <script src="<?= base_url('assets/moment.js-2.29.4/moment.min.js') ?>"></script>
    <script src="<?= base_url("/assets/jquery-validation-1.19.5/jquery.validate.min.js") ?>"></script>
    <script src="<?= base_url("/assets/jquery-validation-1.19.5/additional-methods.min.js") ?>"></script>
    <script type="text/javascript">

        DataTable.Buttons.defaults.dom.button.className = 'btn'; // Sobrescreve a estilização padrão do datatables sobre os botões

        var table = new DataTable('#listar_sinais', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url("sinais/list/json") ?>",
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
        order: [[3, 'asc']],
        language:{url: '<?= base_url("assets/datatables-pt-BR.json") ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: {
                buttons: [{
                    text: '<span class="material-symbols-rounded align-bottom">add</span> Adicionar',
                    className: 'btn btn-primary px-3 py-1',
                    action: function (e, dt, node, config) {
                        $('#sinalModalLabel').text('Adicionar Sinal');
                        $('#sinal_form')[0].reset();
                        $('#sinalModal').data('id', '');
                        $('#sinalModal').modal('show');
                    },
                }]
            },
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'COD_SINAL', visible: false, searchable: false, orderable: false },
            { data: 'COD_COMODO', visible: false, searchable: false, orderable: false },
            { data: 'COD_REDE', visible: false, searchable: false, orderable: false },
            { data: 'COMODO' },
            { data: 'REDE' },
            { data: 'FREQUENCIA' },
            { data: 'VELOCIDADE' },
            { data: 'NIVEL_SINAL' },
            { data: 'INTERFERENCIA' },
            { data: 'DT_ANALISE' },
            {
                data: 'ACOES', 
                searchable: false, 
                orderable: false, 
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 mx-1 editar-sinal" data-id="' + row['COD_SINAL'] + '">' +
                                '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a>' +
                            '<a class="btn btn-sm btn-outline-danger p-0 mx-1 deletar-sinal" data-id="' + row['COD_SINAL'] + '">' +
                                '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deletar">delete</span></a>';
                },
            },
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
            $('#busca_sinal')[0].reset();
            table.ajax.reload(); // Table reload
        });

        $('#cancelar').on('click', function () {
            $('#sinalModal').modal('hide');
        });

        // Abre o modal de Edição
        $('#listar_sinais').on('click', '.editar-sinal', function(e) {
            e.preventDefault();
            $('#sinal_form')[0].reset();
            var rowData = table.row($(this).parents('tr')).data();
            $('#sinalModalLabel').text('Editar Sinal');

            $('#rede').val(rowData['COD_REDE']);
            $('#frequencia').val(rowData['FREQUENCIA']);
            $('#comodo').val(rowData['COD_COMODO']);
            $('#velocidade').val(rowData['VELOCIDADE']);
            $('#dbm').val(rowData['NIVEL_SINAL']);
            $('#interferencia').val(rowData['INTERFERENCIA']);

            $('#sinalModal').data('id', rowData['COD_SINAL']);
            $('#sinalModal').modal('show');
        });

        // Abre o modal de confirmação de exclusão do sinal
        $('#listar_sinais').on('click', '.deletar-sinal', function(e) {
            e.preventDefault();
            var rowData = table.row($(this).parents('tr')).data();

            $('#confirmDeleteModal').data('id', rowData['COD_SINAL']);
            $('#confirmDeleteModal').modal('show');
        });

        // Após confirmar a exclusão:
        $('#confirmDelete').on('click', function() {
            $('#confirmDelete').addClass('disabled');

            var sinalID = $('#confirmDeleteModal').data('id');
            var deleteURL = "<?= base_url('sinais/delete/') ?>" + sinalID;
            $.ajax({
                url: deleteURL, 
                type: "POST",
                success: function (response) {
                    if (response.status === 'error') {
                        mostrarMensagem('danger', response.message);
                    } else {
                        mostrarMensagem('success', 'O sinal foi excluído com sucesso!');
                    }
                },
                error: function (response) {
                    mostrarMensagem('danger', response.message);
                },
                complete: function () {
                    // Fecha o modal
                    table.ajax.reload();
                    $('#confirmDelete').removeClass('disabled');
                    $('#confirmDeleteModal').modal('hide');
                }
            });

            
        });

        $(document).ready(function () {
            // Adiciona método personalizado para validação de select com valor padrão "0"
            $.validator.addMethod("valueNotEquals", function (value, element, arg) {
                return value !== arg;
            }, "Selecione uma opção válida.");

            // Validação dos campos do formulário
            validator = $('#sinal_form').validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    rede: {
                        required: true,
                        valueNotEquals: "0", // Verifica se o valor não é "0"
                    },
                    frequencia: {
                        required: true,
                        valueNotEquals: "0", // Verifica se o valor não é "0"
                    },
                    comodo: {
                        required: true,
                        valueNotEquals: "0", // Verifica se o valor não é "0"
                    },
                    velocidade: {
                        required: true,
                        maxlength: 20,
                    },
                    dbm: {
                        required: true,
                        maxlength: 20,
                        number: true,
                    },
                    interferencia: {
                        required: false,
                        maxlength: 255,
                    },
                },
                messages: {
                    rede: {
                        required: "A Rede é obrigatória.",
                        valueNotEquals: "Selecione uma Rede válida.",
                    },
                    frequencia: {
                        required: "A Frequência é obrigatória.",
                        valueNotEquals: "Selecione uma Frequência válida.",
                    },
                    comodo: {
                        required: "O Cômodo é obrigatório.",
                        valueNotEquals: "Selecione um Cômodo válido.",
                    },
                    velocidade: {
                        required: "A Velocidade é obrigatória.",
                        maxlength: "A Velocidade não deve ter mais de {0} caracteres.",
                    },
                    dbm: {
                        required: "O Nível de Sinal (dBm) é obrigatório.",
                        maxlength: "O Nível de Sinal (dBm) não deve ter mais de {0} caracteres.",
                        number: "O Nível de Sinal (dBm) é inválido.",
                    },
                    interferencia: {
                        maxlength: "Interferências não devem ter mais de {0} caracteres.",
                    },
                },
                invalidHandler: function (e, validator) {
                    var errorMsg = "<ul>";
                    for (var i = 0; i < validator.errorList.length; i++) {
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
                    // Se a validação é bem-sucedida, envia o formulário.
                    var formData = {
                        rede: $('#rede').val(),
                        frequencia: $('#frequencia').val(),
                        comodo: $('#comodo').val(),
                        velocidade: $('#velocidade').val(),
                        dbm: $('#dbm').val(),
                        interferencia: $('#interferencia').val(),
                    };

                    var sinalID = $('#sinalModal').data('id');
                    var url = sinalID ? "<?= base_url('sinais/edit/') ?>" + sinalID : "<?= base_url('sinais/add') ?>";
                    $('#salvar').addClass('disabled');

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: JSON.stringify(formData),
                        contentType: "application/json; charset=utf-8",
                        success: function (response) {
                            if (response.status === 'error') {
                                mostrarMensagem('danger', response.message);
                            } else {

                                if (sinalID) {
                                    mostrarMensagem('success', 'O sinal foi atualizado com sucesso!');
                                } else {
                                    mostrarMensagem('success', 'O sinal foi adicionado com sucesso!');
                                }

                                $('#busca_sinal')[0].reset();
                                table.ajax.reload();
                                $('#sinalModal').modal('hide');
                            }
                        },
                        error: function (response) {
                            mostrarMensagem('danger', response.message);
                        },
                        complete: function () {
                            $('#busca_sinal')[0].reset();
                            $('#salvar').removeClass('disabled');
                        }
                    });
                }
            });
        });


        $('#salvar').click(function () {
            $('#sinal_form').submit(); // Form submit -> Acionamento da validação
        });


    </script>

<?= $this->endsection() ?>
