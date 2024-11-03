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
                <table id="listar_analise" class="table table-hover table-md align-middle">
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

    var table = new DataTable('#listar_analise', {
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('analise/load/json') ?>",
            type: "POST",
            data: function(d) {
                d.filtroComodo = $('#filtroComodo').val();
            }
        },
        info: true,
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']],
        language: { url: '<?= base_url('assets/datatables-pt-BR.json') ?>', decimal: ',', thousands: '.' },
        layout: {
            topStart: {},
            topEnd: 'pageLength',
        },
        columnDefs: [{ targets: "_all", orderSequence: ['asc', 'desc'], className: "dt-body-left dt-head-left" }],
        columns: [
            { data: 'ID', visible: false, searchable: false },
            { data: 'NOME' },
            { data: 'ID_ORGAO', visible: false, searchable: false },
            { data: 'NOME_ORGAO' },
            {
                data: 'ACOES',
                searchable: false,
                orderable: false,
                className: 'dt-body-center dt-head-center',
                render: function (data, type, row) {
                    return '<a href="#" class="btn btn-sm btn-outline-success p-0 editar-unidade" data-id="' + row['ID'] + '"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar">edit</span></a>'
                    + '<a href="<?= base_url("unidades/log/") ?>' + row['ID'] + '" class="btn btn-sm btn-outline-secondary p-0 historico-unidade" id="unidadeHistory"><span class="material-symbols-rounded align-middle tt" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Histórico de Alterações">history</span></a>';
                }
            }
        ]
    });

    // Carregamento de Tooltip ao iniciar o DataTables
    table.on('draw.dt', function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // Validação do formulário
    $('#filtrar').on('click', function(event) {
        event.preventDefault();
        table.ajax.reload();
    });

    // Limpeza do formulário de filtragem
    $('#limpar').on('click', function(){
        $('#msgError').attr('hidden', '');
        $('#buscar_unidades')[0].reset();
        table.ajax.reload(); // Reload na tabela
    });

    $('#cancelar').on('click', function () {
        $('#unidadeModal').modal('hide');
    });

    // Ação para abrir modal de edição ao clicar no botão edit
    $('#listar_unidades').on('click', '.editar-unidade', function(e) {
        e.preventDefault();
        var rowData = table.row($(this).parents('tr')).data();
        $('#unidadeModalLabel').text('Editar Unidade');
        $('#nome').val(rowData['NOME']);
        $('#orgao').val(rowData['ID_ORGAO']);
        $('#orgao').prop('disabled', true);
        $('#unidadeModal').data('id', rowData['ID']);
        $('#unidadeModal').modal('show');
    });


    $(document).ready(function () {

        // Validação dos campos do formulário
        validator = $('#unidadeForm').validate({
            onfocusout: false,  // Desativa a revalidação quando o campo perde o foco
            onkeyup: false,     // Desativa a revalidação ao digitar
            onclick: false,     // Desativa a revalidação ao clicar (útil para checkboxes e radios)
            rules: {
                nome: {
                    required: true,
                    maxlength: 125,
                },
                orgao: {
                    required: true,
                },
            },
            messages: {
                nome: {
                    required: "O campo NOME deve ser preenchido.",
                    maxlength: "O nome deve ter no máximo {0} caracteres.",
                },
                orgao: {
                    required: "Um Órgão deve ser selecionado.",
                },
            },
            invalidHandler: function(e,validator) {
                // Construção do bloco de mensagem do toast com base nos erros retornados:
                var errorMsg = "<ul>";
                // validator.errorList contains an array of objects, where each object has properties "element" and "message".  element is the actual HTML Input.
                for (var i = 0; i < validator.errorList.length; i++){
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
                // Se a validação for bem-sucedida, envia os dados para o servidor
                var formData = {
                    nome: $('#nome').val(),
                    orgao: $('#orgao').val(),
                };
                var unidadeId = $('#unidadeModal').data('id');
                var url = unidadeId ? "<?= base_url('unidades/edit/') ?>" + unidadeId : "<?= base_url('unidades/add') ?>";
                $('#salvar').addClass('disabled');
                $.ajax({
                    url: url,
                    type: "POST",
                    data: JSON.stringify(formData),
                    contentType: "application/json; charset=utf-8",
                    success: function(response) {
                        if (response.status === 'error') {
                            mostrarMensagem('danger', response.message);
                        } else {
                            mostrarMensagem('success', unidadeId ? 'Unidade atualizada com sucesso!' : 'Unidade cadastrada com sucesso!');
                            $('#buscar_unidades')[0].reset();
                            table.ajax.reload();
                            $('#unidadeModal').modal('hide');
                        }
                    },
                    error: function(xhr, status, error) {
                        mostrarMensagem('danger', 'Erro ao salvar unidade: ' + error);
                    },
                    complete: function () {
                        $('#buscar_unidades')[0].reset();
                        $('#salvar').removeClass('disabled');
                    }
                });
            } 
        });
        // Ajuste do evento de clique no botão "Salvar"
        $('#salvar').click(function () {
            $('#unidadeForm').submit(); // Submeter o formulário para acionar a validação
        });
    });
    
</script>

<?= $this->endsection() ?>