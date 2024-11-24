<?= $this->extend('layouts/default') ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="container pt-5 mt-5 text-center text-white">
        <h1 class="p-0 m-0 mt-5 fw-bolder">Gestão de Redes</h1>
    </div>

    <div class="container pt-5 mt-3">
        <form id="busca_rede" class="mb-4" method="post" accept-charset="utf-8">
            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-4 px-1">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text">Rede</span>
                        <input type="text" class="form-control" name="filtroRede" id="filtroRede" maxlength="125">
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
        <div class="modal fade" id="redeModal" tabindex="-1" role="dialog" aria-labelledby="redeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="redeModalLabel"></h5>
                    </div>
                    <div class="modal-body bg-light">
                        <form id="rede_form">
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-5 px-1 pb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">Nome</span>
                                        <input type="text" class="form-control" name="nome" id="nome" maxlength="125">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-5 px-1 pb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">Velocidade</span>
                                        <input type="text" class="form-control" name="velocidade" id="velocidade" maxlength="20">
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
                        <p>Tem certeza de que deseja excluir esta rede?</p>
                        <p>Todos os dados relacionados a esta rede serão <strong>permanentemente</strong> excluídos.</p>
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
            <div class="col-10 mb-5 p-3 table-responsive text-white">
                <table id="listar_redes" class="table table-hover table-striped table-sm align-middle">
                    <thead style="background-color: #1E3E62;">
                        <tr>
                            <th scope="col" class="col text-white">COD_REDE</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">Rede</th>
                            <th scope="col" class="col-2 text-white">Pacote de Dados</th>
                            <th scope="col" class="col text-white">Info</th>
                            <th scope="col" class="col-1 text-white">Ações</th>
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

        var table = new DataTable('#listar_redes', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url("redes/list/json") ?>",
            type: "POST",
            data: function(d) {
                d.filtroRede = $("#filtroRede").val();
            }
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']],
        language:{url: '<?= base_url("assets/datatables-pt-BR.json") ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: {
                buttons: [{
                    text: '<span class="material-symbols-rounded align-bottom">add</span> Adicionar',
                    className: 'btn btn-primary px-3 py-1',
                    action: function (e, dt, node, config) {
                        $('#redeModalLabel').text('Adicionar Rede');
                        $('#rede_form')[0].reset();
                        $('#redeModal').data('id', '');
                        $('#redeModal').modal('show');
                    },
                }]
            },
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'COD_REDE', visible: false, searchable: false, orderable: false },
            { data: 'NOME' },
            { data: 'PACOTE_DADOS', orderable: false },
            { 
                data: 'INFO', 
                orderable: false, 
                searchable: false,
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 mx-1 info-rede" data-id="' + row['COD_REDE'] + '">' +
                            '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Informações">info</span></a>'
                }
            },
            {
                data: 'ACOES', 
                searchable: false, 
                orderable: false, 
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 mx-1 editar-rede" data-id="' + row['COD_REDE'] + '">' +
                                '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a>' +
                            '<a class="btn btn-sm btn-outline-danger p-0 mx-1 deletar-rede" data-id="' + row['COD_REDE'] + '">' +
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
            $('#busca_rede')[0].reset();
            table.ajax.reload(); // Table reload
        });

        $('#cancelar').on('click', function () {
            $('#redeModal').modal('hide');
        });

        // Abre o modal de Edição
        $('#listar_redes').on('click', '.editar-rede', function(e) {
            e.preventDefault();
            $('#rede_form')[0].reset();
            var rowData = table.row($(this).parents('tr')).data();
            $('#redeModalLabel').text('Editar Rede');

            $('#nome').val(rowData['NOME']);
            $('#velocidade').val(rowData['PACOTE_DADOS']);
            $('#redeModal').data('id', rowData['COD_REDE']);
            $('#redeModal').modal('show');
        });

        // Abre o modal de confirmação de exclusão da rede
        $('#listar_redes').on('click', '.deletar-rede', function(e) {

            e.preventDefault();
            var rowData = table.row($(this).parents('tr')).data();

            $('#confirmDeleteModal').data('id', rowData['COD_REDE']);
            $('#confirmDeleteModal').modal('show');
        });

        // Após confirmar a exclusão:
        $('#confirmDelete').on('click', function() {
            $('#confirmDelete').addClass('disabled');

            var redeID = $('#confirmDeleteModal').data('id');
            var deleteURL = "<?= base_url('redes/delete/') ?>" + redeID;
            $.ajax({
                url: deleteURL, 
                type: "POST",
                success: function (response) {
                    if (response.status === 'error') {
                        mostrarMensagem('danger', response.message);
                    } else {
                        mostrarMensagem('success', 'A rede foi excluída com sucesso!');
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
            // Validação dos campos do formulário
            validator = $('#rede_form').validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    nome: {
                        required: true,
                        maxlength: 125,
                    },
                    velocidade: {
                        required: true,
                        maxlength: 20,
                    },
                },
                messages: {
                    nome: {
                        required: "O Nome da Rede é obrigatório.",
                        maxlength: "O Nome da Rede não deve ter mais de {0} caracteres.",
                    },
                    velocidade: {
                        required: "A Velocidade da Rede é obrigatória.",
                        maxlength: "A Velocidade da Rede não deve ter mais de {0} caracteres.",
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
                        nome: $('#nome').val(),
                        velocidade: $('#velocidade').val(),
                    };

                    var redeID = $('#redeModal').data('id');
                    var url = redeID ? "<?= base_url('redes/edit/') ?>" + redeID : "<?= base_url('redes/add') ?>";
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

                                if(redeID) {
                                    mostrarMensagem('success', 'A rede foi atualizada com sucesso!');
                                } else {
                                    mostrarMensagem('success', 'A rede foi adicionada com sucesso!');
                                }

                                $('#busca_rede')[0].reset();
                                table.ajax.reload();
                                $('#redeModal').modal('hide');
                            }
                        },
                        error: function (response) {
                            mostrarMensagem('danger', response.message);
                        },
                        complete: function () {
                            $('#busca_rede')[0].reset();
                            $('#salvar').removeClass('disabled');
                        }
                    });
                }
            });
        });

        $('#salvar').click(function () {
            $('#rede_form').submit(); // Form submit -> Acionamento da validação
        });


    </script>

<?= $this->endsection() ?>
