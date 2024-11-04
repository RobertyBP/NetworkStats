<?= $this->extend('layouts/default') ?>

<?= $this->section('more-styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/css/dataTables.bootstrap5.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/DataTables-2.0.3/Buttons-3.0.1/css/buttons.bootstrap5.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="container pt-5 mt-5 text-center text-white">
        <h1 class="p-0 m-0 mt-5 fw-bolder">Gestão de Usuários</h1>
    </div>

    <div class="container pt-5 mt-3">
        <form id="busca_usuario" class="mb-4" method="post" accept-charset="utf-8">
            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-4 px-1">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text">Nome</span>
                        <input type="text" class="form-control" name="filtroNome" id="filtroNome" maxlength="255">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pb-3 align-items-center">
                <div class="col-4 px-1">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text">E-mail</span>
                        <input type="text" class="form-control" name="filtroEmail" id="filtroEmail" maxlength="150">
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
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="userModalLabel"></h5>
                    </div>
                    <div class="modal-body bg-light">
                        <form id="user_form">
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-5 px-1 pb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">E-mail</span>
                                        <input type="email" class="form-control" name="email" id="email" maxlength="150">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-5 px-1 pb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text">Nome</span>
                                        <input type="text" class="form-control" name="nome" id="nome" minlength="7" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center pb-3 align-items-center">
                                <div class="col-3 px-1 pb-2">
                                    <div class="input-group shadow-sm">
                                        <label for="permissao" class="input-group-text">Permissão</label>
                                        <select class="form-select" id="permissao" name="permissao">
                                            <option selected value="0">Leitor</option>
                                            <option value="1">Admin</option>
                                        </select>
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
                        <p>Tem certeza de que deseja excluir este usuário?</p>
                        <p>Todos os dados relacionados a este usuário serão <strong>permanentemente</strong> excluídos.</p>
                        <p>Essa ação não poderá ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Excluir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-start small">
            <div class="col-12 mb-5 p-3 table-responsive text-white">
                <table id="listar_usuarios" class="table table-hover table-striped table-sm align-middle">
                    <thead style="background-color: #1E3E62;">
                        <tr>
                            <th scope="col" class="col text-white">ID</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">UUID</th><!-- Apenas para validação interna. Não é exibido no DATATABLES -->
                            <th scope="col" class="col text-white">Nome</th>
                            <th scope="col" class="col text-white">E-mail</th>
                            <th scope="col" class="col text-white">Permissão</th>
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

        var table = new DataTable('#listar_usuarios', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url("users/list/json") ?>",
            type: "POST",
            data: function(d) {
                d.filtroNome = $("#filtroNome").val();
                d.filtroEmail = $("#filtroEmail").val();
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
                    text: '<span class="material-symbols-rounded align-bottom">person_add</span> Adicionar',
                    className: 'btn btn-primary px-3 py-1',
                    action: function (e, dt, node, config) {
                        $('#userModalLabel').text('Adicionar Usuário');
                        $('#user_form')[0].reset();
                        $('#userModal').data('id', '');
                        $('#userModal').modal('show');
                    },
                }]
            },
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'COD_USER', visible: false, searchable: false, orderable: false },
            { data: 'UUID', visible: false, searchable: false, orderable: false },
            { data: 'NOME' },
            { data: 'EMAIL', orderable: false },
            { data: 'PERMISSAO', searchable: false,
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    if(row['PERMISSAO'] == '1') { // Admin
                        return '<span class="material-symbols-rounded align-bottom text-primary btn tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin">shield_person</span>'
                    } else if(row['PERMISSAO'] == '0'){ // Leitor
                        return '<span class="material-symbols-rounded align-bottom text-primary btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Leitor">visibility</span>'
                    }
                }
            },
            {
                data: 'ACOES', 
                searchable: false, 
                orderable: false, 
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a class="btn btn-sm btn-outline-primary p-0 mx-1 editar-usuario" data-id="' + row['COD_USER'] + '">' +
                                '<span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a>' +
                            '<a class="btn btn-sm btn-outline-danger p-0 mx-1 deletar-usuario" data-id="' + row['COD_USER'] + '">' +
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
            $('#busca_usuario')[0].reset();
            table.ajax.reload(); // Table reload
        });

        $('#cancelar').on('click', function () {
            $('#userModal').modal('hide');
        });

        // Abre o modal de Edição
        $('#listar_usuarios').on('click', '.editar-usuario', function(e) {
            e.preventDefault();
            $('#user_form')[0].reset();
            var rowData = table.row($(this).parents('tr')).data();
            $('#userModalLabel').text('Editar Usuário');

            $('#nome').val(rowData['NOME']);
            $('#email').val(rowData['EMAIL']);
            $('#permissao').val(rowData['PERMISSAO']);
            $('#userModal').data('id', rowData['COD_USER']);
            $('#userModal').modal('show');
        });

        // Abre o modal de confirmação de exclusão do usuário
        $('#listar_usuarios').on('click', '.deletar-usuario', function(e) {

            e.preventDefault();
            var rowData = table.row($(this).parents('tr')).data();

            $('#confirmDeleteModal').data('id', rowData['COD_USER']);
            $('#confirmDeleteModal').modal('show');
        });

        // Após confirmar a exclusão:
        $('#confirmDelete').on('click', function() {
            $('#confirmDelete').addClass('disabled');

            var userID = $('#confirmDeleteModal').data('id');
            var deleteURL = "<?= base_url('users/delete/') ?>" + userID;
            $.ajax({
                url: deleteURL, 
                type: "POST",
                success: function (response) {
                    if (response.status === 'error') {
                        mostrarMensagem('danger', response.message);
                    } else {
                        mostrarMensagem('success', 'O usuário foi excluído com sucesso!');
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
            validator = $('#user_form').validate({
                onfocusout: false,
                onkeyup: false,
                onclick: false,
                rules: {
                    nome: {
                        required: true,
                        maxlength: 150,
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 8,
                        maxlength: 125,
                    },
                    permissao: {
                        required: true,
                        range: [0, 1],
                    },
                },
                messages: {
                    name: {
                        required: "O Nome do Usuário é obrigatório.",
                        maxlength: "O nome não deve ter mais de {0} caracteres.",
                    },
                    email: {
                        required: "O E-mail do Usuário é obrigatório.",
                        email: "O E-mail do Usuário deve conter um endereço de e-mail válido.",
                        minlength: "O E-mail deve conter no mínimo {0} caracteres.",
                        maxlength: "O E-mail deve conter no máximo {0} caracteres.",
                    },
                    permissao: {
                        required: "O nível de permissão do usuário é obrigatório.",
                        range: "O nível de permissão do usuário é inválido.",
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
                        email: $('#email').val(),
                        permissao: $('#permissao').val(),
                    };

                    var userId = $('#userModal').data('id');
                    var url = userId ? "<?= base_url('users/edit/') ?>" + userId : "<?= base_url('users/add') ?>";
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

                                if(userId) {
                                    mostrarMensagem('success', 'O usuário foi atualizado com sucesso!');
                                } else {
                                    // Copia a senha para o clipboard
                                    var tempPassword = response.data;
                                    copyToClipboard(tempPassword);

                                    mostrarMensagem('success', 'O usuário foi adicionado com sucesso. A primeira senha de acesso do usuário foi copiada para o seu clipboard!');
                                }

                                $('#busca_usuario')[0].reset();
                                table.ajax.reload();
                                $('#userModal').modal('hide');
                            }
                        },
                        error: function (response) {
                            mostrarMensagem('danger', response.message);
                        },
                        complete: function () {
                            $('#busca_usuario')[0].reset();
                            $('#salvar').removeClass('disabled');
                        }
                    });
                }
            });
        });

        function copyToClipboard(value) {
            navigator.clipboard.writeText(value);
        }

        $('#salvar').click(function () {
            $('#user_form').submit(); // Form submit -> Acionamento da validação
        });


    </script>

<?= $this->endsection() ?>
