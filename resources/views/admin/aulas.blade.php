@extends('layouts/admin/header/header')
@section('titulo','Aulas | Portal do Aluno')
@section('conteudo')
<main>
<div id="modulos" class="box">
        <h3>
            Aulas
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Nova Aula <span></div>
        </h3>
        <div class="clear"></div>
        <table id="tModulos" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Aulas</td>
                    <td class="mini-title upper">Curso | Módulo</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="criar" class="content suave">
        <h4>Criar Aula <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-aula">
            <label for="aula_nome">Aula</label>
            <input type="text" name="aula_nome" id="aula_nome" placeholder="Nome da aula" required>
            <label for="aula_descricao">Descrição</label>
            <textarea name="aula_descricao" id="aula_descricao" placeholder="Descrição aula"></textarea>
            <div class="metade esquerda">
                <label for="aula_ordem">Posição</label>
                <input type="text" name="aula_ordem" id="aula_ordem" placeholder="Ex: 1..." required="" maxlength="3">
            </div>
            <div class="metade direita">
            <label for="modulo_id">Qual Módulo?</label>
                <select name="modulo_id" id="modulo_id">
                    @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar Aula <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-aula">
            <input type="hidden" name="e_aula_id" id="e_aula_id" value="">
            <label for="e_aula_nome">Aula</label>
            <input type="text" name="e_aula_nome" id="e_aula_nome" placeholder="Nome da aula" required>
            <label for="e_aula_descricao">Descrição</label>
            <textarea name="e_aula_descricao" id="e_aula_descricao" placeholder="Descrição aula"></textarea>
            <div class="metade esquerda">
                <label for="e_aula_ordem">Posição</label>
                <input type="text" name="e_aula_ordem" id="e_aula_ordem" placeholder="Ex: 1..." required="" maxlength="3">
            </div>
            <div class="metade direita">
            <label for="e_modulo_id">Qual Módulo?</label>
                <select name="e_modulo_id" id="e_modulo_id">
                    @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
</div>
<div id="alerta" class="suave">
    <div class="box">
        <h6 class="mini-title upper">aviso:</h6>
        <p></p>
        <div class="opcoes right-align hide">
            <button class="mini-title upper click suave confirmar">sim</button>
            <button class="mini-title upper click suave cancelar">não</button>
        </div>
    </div>
</div>
<script>
    $(".criar").click(function(){
        $("#lateral, #criar").addClass("active");
    });
    $("#lateral .fechar").click(function(){
        $("#lateral, #lateral .content").removeClass("active");
    });

    $("#form-editar-aula").submit(function(e){
        e.preventDefault();
        $("#form-editar-aula button").prop('disabled', true);
        editar();
    });

    $("#form-criar-aula").submit(function(e){
        e.preventDefault();
        $("#form-criar-aula button").prop('disabled', true);
        criar();
    });

    function criar(){
        var form = new FormData($("#form-criar-aula")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aulas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar Aula!",5000);
                $("#form-criar-aula button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-aula")[0].reset();
                $("#form-criar-aula button").prop('disabled', false);
                criaAlerta(0, "Aula criada com sucesso!",5000);
                recarregar();
            }
        });
    }

    function editar(){
        var form = new FormData($("#form-editar-aula")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aulas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao editar Aula!",5000);
                $("#form-editar-aula button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-aula")[0].reset();
                $("#form-editar-aula button").prop('disabled', false);
                criaAlerta(0, "Aula editada com sucesso!",5000);
                recarregar();
            }
        });
    }

    function recarregar(){
        table.ajax.reload();
    }
    
    var table;
    function carregar(){
        table = $('#tModulos').DataTable({
            ajax: {
                url: 'aulas-lista2',
                dataSrc: ''
            },
            columns: [
                {data: 'aula_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'aula_nome'},
                {data: null, width: "300px", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                    return row.modulo.ua.curso.curso_nome  + ' - ' + row.modulo.modulo_nome;
                    }
                },
                {data: 'acoes', width: "80px", className: 'dt-body-center dt-head-center'}
            ],
            columnDefs: [
                {
                    targets: -1,
                    width: "80px",
                    className: 'dt-body-center dt-head-center',
                    data: null,
                    <?php if(Auth::user()->cargo_id == 1){ ?>
                    defaultContent: '<i class="material-icons click suave editar">create</i><i class="material-icons click suave deletar">delete</i>'
                    <?php }else{ ?>
                    defaultContent: '<i class="material-icons click suave editar">create</i>'
                    <?php } ?>
                }
            ],
            language: {
                processing:     "Carregando",
                search:         "Pesquisar",
                lengthMenu:     "Mostrando _MENU_ registros",
                info:           "De _START_ à _END_ de _TOTAL_ registros",
                paginate: {
                    first:      "Primeiro",
                    previous:   "Anterior",
                    next:       "Próximo",
                    last:       "Último"
                },
                emptyTable:     "Nenhum registro cadastrado!",
                zeroRecords:    "Nenhum registro encontrado!",
                loadingRecords: "Carregando...",
                infoEmpty:      "Nenhum registro encontrado",
                infoFiltered:   "(filtrado de _MAX_ cadastros)",

            }

        });
        $(document).on("click", ".editar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #editar").addClass("active");
            $("#editar #e_aula_id").val(data.aula_id);
            consultar(data.aula_id);
        });
        var delete_id;
        $(document).on("click", ".deletar", function(){
            delete_id = table.row($(this).parents("tr")).data();
            $("#alerta p").empty();
            $("#alerta p").text("Deseja realmente deletar este curso ?");
            $("#alerta .opcoes").removeClass("hide");
            $("#alerta").addClass("active");
        });
        $("#alerta .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(delete_id.aula_id);
        });
    }carregar();

    function consultar(aula_id){
        request = $.ajax({
            url: 'aulas/'+ aula_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",5000);
            }
        });
        request.done(function(response){
            $('#editar input[name="e_aula_nome"]').val(response.aula_nome);
            $('#form-editar-aula textarea[name="e_aula_descricao"]').val(response.aula_descricao);
            $('#editar input[name="e_aula_ordem"]').val(response.aula_ordem);
            $('#form-editar-aula #e_modulo_id option[value="'+response.modulo_id+'"]').prop("selected", true);
        });
    }

    function deletar(aula_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aulas/' + aula_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao remover modulo!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Aula removida com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                recarregar();
            }
        });
    }
</script>
@endsection