@include('layouts.admin.head')
@section('titulo','Portal do Aluno | Cursos ')

<main>
    <h3>Cursos<div class="click suave criar"><span>Novo curso</span><i class="material-icons">add_circle</i></div></h3>
    <div id="cursos" class="box">
    <table id="tabela" class="stripe">
        <thead>
            <tr>
                <td>#</td>
                <td>Titulo</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</main>
<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="formCriar" class="content suave">
        <h4>Criar Curso <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-curso">
            <label for="curso_nome">Nome Curso</label>
            <input type="text" name="curso_nome" id="curso_nome" placeholder="Nome do Curso" required>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="aUnidade" class="content suave">
        <h4 class="barlow">Adicionar unidade <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-adicionar-unidade" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ua_curso_id" id="ua_curso_id" value="" required>
            <label for="ua_nome">Nome</label>
            <input type="text" name="ua_nome" id="ua_nome" placeholder="Nome da unidade" required>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="aModulo" class="content suave">
        <h4 class="barlow">Adicionar módulo <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-adicionar-modulo" method="post" enctype="multipart/form-data">
            <label for="modulo_nome">Nome</label>
            <input type="text" name="modulo_nome" id="modulo_nome" placeholder="Nome do módulo" required>
            <label for="ud_id">Unidade</label>
            <select name="ua_id" id="ua_id"></select>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="aAula" class="content suave">
        <h4 class="barlow">Adicionar aula <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-adicionar-aula" method="post" enctype="multipart/form-data">
            <label for="aula_nome">Título</label>
            <input type="text" name="aula_nome" id="aula_nome" placeholder="Título da aula" required>
            <label for="aula_descricao">Descrição</label>
            <textarea name="aula_descricao" id="aula_descricao"></textarea>
            <div class="metade esquerda">
                <label for="aula_ordem">Nº da aula</label>
                <input type="number" name="aula_ordem" id="aula_ordem" required>
            </div>
            <div class="metade direita">
                <label for="modulo_id">Módulo</label>
                <select name="modulo_id" id="modulo_id"></select>
            </div>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
</div>

<div id="confirmar" class="suave">
    <p>Deseja realmente deletar este item?</p>
    <div class="opcoes right-align">
        <button class="mini-title upper click suave confirmar">sim</button>
        <button class="mini-title upper click suave cancelar">não</button>
    </div>
</div>

<script>
    $(".criar").click(function() {
        $("#lateral, #criar").addClass("active");
    });

    $("#formCriar").submit(function(e) {
        e.preventDefault();
        $("#formCriar button").prop('disabled', true);
        criar();
    });

    $("#formEditar").submit(function(e) {
        e.preventDefault();
        $("#formEditar button").prop('disabled', true);
        editar();
    });

    $("#lateral .fechar").click(function() {
        $("#lateral, #lateral .content").removeClass("active");
    });

    var table;
    function carregar() {
        table = $('#tabela').DataTable({
            ajax: {
                url: 'cursos-lista',
                dataSrc: ''
            },
            columns: [{
                    data: 'curso_id',
                    width: "60px",
                    className: 'dt-body-center dt-head-center'
                },
                {
                    data: 'curso_nome'
                },
                {
                    data: '',
                }
            ],
            columnDefs: [{
                targets: -1,
                width: "190px",
                className: 'dt-body-center dt-head-center',
                data: null,
                defaultContent: '<i class="material-icons click suave adicionar-unidade" title="Adicionar unidades">view_list</i><i class="material-icons click suave adicionar-modulo"  title="Adicionar módulos">list</i><i class="material-icons click suave adicionar-aula"  title="Adicionar aulas">playlist_add</i><i class="material-icons click suave editar">create</i><i class="material-icons click suave deletar">delete</i>'
            }],
            language: {
                processing: "Carregando",
                search: "Pesquisar",
                lengthMenu: "Mostrando _MENU_ registros",
                info: "De _START_ à _END_ de _TOTAL_ registros",
                paginate: {
                    first: "Primeiro",
                    previous: "Anterior",
                    next: "Próximo",
                    last: "Último"
                },
                emptyTable: "Nenhum registro cadastrado!",
                zeroRecords: "Nenhum registro encontrado!",
                loadingRecords: "Carregando...",
                infoEmpty: "Nenhum registro encontrado",
                infoFiltered: "(filtrado de _MAX_ cadastros)",
            }
        });

        $(document).on("click", ".editar", function() {
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #editar").addClass("active");
            consultar(data.curso_id);
        });

        var delete_id;
        $(document).on("click", ".deletar", function() {
            var data = table.row($(this).parents("tr")).data();
            delete_id = data.curso_id;
            $("#confirmar").addClass("active");
        });

        $("#confirmar .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(delete_id);
        });

        $(document).on("click", ".adicionar-unidade", function() {
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #aUnidade").addClass("active");
            $("#aUnidade #ua_curso_id").val(data.curso_id);
        });

        $(document).on("click", ".adicionar-modulo", function() {
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #aModulo").addClass("active");
            consultaUnidades(data.curso_id);
        });

        $(document).on("click", ".adicionar-aula", function() {
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #aAula").addClass("active");
            consultaModulos(data.curso_id);
        });
    }
    carregar();

    function recarregar() {
        table.ajax.reload();
    }

    function criar() {
        var form = new FormData($("#formCriar")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cursos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function() {
                alerta("Falha ao criar Curso!");
                $("#formCriar button").prop('disabled', false);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#lateral, #lateral .content").removeClass("active");
                $("#formCriar")[0].reset();
                $("#formCriar button").prop('disabled', false);
                alerta("Curso criado com sucesso!");
                recarregar();
            }
        });
    }

    function consultar(id_curso) {
        request = $.ajax({
            url: 'editar-curso/' + id_curso,
            type: 'get',
            error: function() {
                alerta("Falha na consulta!");
            }
        });
        request.done(function(response) {
            $('#formEditar input[name="e_id_curso"]').val(response.curso_id);
            $('#formEditar input[name="e_curso_nome"]').val(response.curso_nome);
        });
    }

    function editar() {
        var form = new FormData($("#form-editar-curso")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cursos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function() {
                alerta("Falha ao editar Curso!");
                $("#formEditar button").prop('disabled', false);
            }
        });
        request.done(function(response) {
            if (response == "2") {
                $("#lateral, #lateral .content").removeClass("active");
                $("#formEditar")[0].reset();
                $("#formEditar button").prop('disabled', false);
                alerta("Curso atualizado com sucesso!");
                recarregar();
            }
        });
    }

    function deletar(id_curso) {
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'deletar-curso/' + id_curso,
            type: 'delete',
            error: function() {
                alerta("Falha ao deletar Curso!");
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#confirmar").removeClass("active");
                $("#confirmar .confirmar").prop('disabled', false);
                alerta("Curso deletado com sucesso!");
                recarregar();
            } else {
                $("#confirmar").removeClass("active");
                $("#confirmar .confirmar").prop('disabled', false);
                alerta("Este Curso possue modulos atrelados a ele, favor modificar para realizar esta ação!");
            }
        });
    }

    $("#form-adicionar-unidade").submit(function(e) {
        e.preventDefault();
        $("#form-adicionar-unidade button").prop('disabled', true);
        adicionarUnidade();
    });

    $("#form-adicionar-modulo").submit(function(e) {
        e.preventDefault();
        $("#form-adicionar-modulo button").prop('disabled', true);
        adicionarModulo();
    });

    $("#form-adicionar-aula").submit(function(e) {
        e.preventDefault();
        $("#form-adicionar-aula button").prop('disabled', true);
        adicionarAula();
    });

    function adicionarUnidade() {
        var form = new FormData($("#form-adicionar-unidade")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'unidade-academica',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function() {
                criaAlerta(0, "Falha ao criar unidade!", 5000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-adicionar-unidade")[0].reset();
                $("#form-adicionar-unidade button").prop('disabled', false);
                criaAlerta(0, "Unidade criada com sucesso!", 5000);
            }
        });
    }

    function consultaUnidades(curso_id) {
        request = $.ajax({
            url: 'uas-lista/' + curso_id,
            type: 'get',
            error: function() {
                criaAlerta(0, "Falha na consulta!", 5000);
            }
        });
        request.done(function(response) {
            $("#ua_id").empty();
            response.forEach(ua => {
                var option = document.createElement("option");
                option.setAttribute("value", ua.ua_id);
                option.innerHTML = ua.ua_nome;
                $("#ua_id").append(option);
            });
        });
    }

    function deletarUnidade(unidade_id, curso_id) {
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'unidade-academica/' + unidade_id,
            type: 'delete',
            error: function() {
                criaAlerta(0, "Falha ao remover unidade!", 2000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Unidade removida com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function() {
                    $("#alerta").removeClass("active");
                }, 2000);
                $("#visualizar .conteudo").empty();
                carregarCurso(curso_id);
            } else {
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Esta unidade possui módulos atreladas a ela, remova seus módulos primeiro!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function() {
                    $("#alerta").removeClass("active");
                }, 5000);
            }
        });
    }

    function adicionarModulo() {
        var form = new FormData($("#form-adicionar-modulo")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/modulos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function() {
                criaAlerta(0, "Falha ao criar módulo!", 5000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-adicionar-modulo")[0].reset();
                $("#form-adicionar-modulo button").prop('disabled', false);
                criaAlerta(0, "Módulo criado com sucesso!", 5000);
            }
        });
    }

    function consultaModulos(curso_id) {
        request = $.ajax({
            url: 'modulos-lista/' + curso_id,
            type: 'get',
            error: function() {
                criaAlerta(0, "Falha na consulta!", 5000);
            }
        });
        request.done(function(response) {
            $("#modulo_id").empty();
            response.forEach(modulo => {
                var option = document.createElement("option");
                option.setAttribute("value", modulo.modulo_id);
                option.innerHTML = modulo.modulo_nome;
                $("#modulo_id").append(option);
            });
        });
    }

    function deletarModulo(modulo_id, curso_id) {
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'modulos/' + modulo_id,
            type: 'delete',
            error: function() {
                criaAlerta(0, "Falha ao remover módulo!", 2000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Módulo removido com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function() {
                    $("#alerta").removeClass("active");
                }, 2000);
                $("#visualizar .conteudo").empty();
                carregarCurso(curso_id);
            } else {
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Este módulo possui aulas atreladas a ele, remova suas aulas primeiro!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function() {
                    $("#alerta").removeClass("active");
                }, 5000);
            }
        });
    }

    function adicionarAula() {
        var form = new FormData($("#form-adicionar-aula")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aulas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function() {
                criaAlerta(0, "Falha ao criar aula!", 5000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-adicionar-aula")[0].reset();
                $("#form-adicionar-aula button").prop('disabled', false);
                criaAlerta(0, "Aula criada com sucesso!", 5000);
            }
        });
    }

    function deletarAula(aula_id, curso_id) {
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aulas/' + aula_id,
            type: 'delete',
            error: function() {
                criaAlerta(0, "Falha ao remover aula!", 2000);
            }
        });
        request.done(function(response) {
            if (response == "1") {
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Aula removida com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function() {
                    $("#alerta").removeClass("active");
                }, 2000);
                $("#visualizar .conteudo").empty();
                carregarCurso(curso_id);
            }
        });
    }
</script>