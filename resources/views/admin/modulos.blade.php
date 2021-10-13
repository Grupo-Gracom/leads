@extends('layouts/admin/header/header')
@section('titulo','Modulos | Portal do Aluno')
@section('conteudo')
<main>
<div id="modulos" class="box">
        <h3>
            Modulos
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Novo Modulo<span></div> 
        </h3>
        <div class="clear"></div>
        <table id="tModulos" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Modulos</td>
                    <td class="mini-title upper">Curso | unidade</td>
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
        <h4>Criar Modulo <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-modulo">
            <label for="modulo_nome">Modulo</label>
            <input type="text" name="modulo_nome" id="modulo_nome" placeholder="Nome do Modulo" required>
            <label for="curso">Qual Curso?</label>
                <select name="ua_id" id="ua_id">
                    @foreach($cursos as $curso)
                    <option value="{{$curso->ua_id}}">{{$curso->curso->curso_nome }} - {{ $curso->ua_nome }}</option>
                    @endforeach
                </select>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar Modulo <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-modulo">
            <input type="hidden" name="e_modulo_id" id="e_modulo_id" value="">
            <label for="e_modulo_nome">Modulo</label>
            <input type="text" name="e_modulo_nome" id="e_modulo_nome" placeholder="Nome do Modulo" required>
            <label for="e_curso">Qual Curso?</label>
                <select name="e_ua_id" id="e_ua_id">
                    @foreach($cursos as $curso)
                    <option value="{{$curso->ua_id}}">{{$curso->curso->curso_nome }} - {{ $curso->ua_nome }}</option>
                    @endforeach
                </select>
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

    $("#form-criar-modulo").submit(function(e){
        e.preventDefault();
        $("#form-criar-modulo button").prop('disabled', true);
        criar();
    });

    $("#form-editar-modulo").submit(function(e){
        e.preventDefault();
        $("#form-editar-modulo button").prop('disabled', true);
        editar();
    });

    function editar(){
        var form = new FormData($("#form-editar-modulo")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'modulos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao editar Modulo!",5000);
                $("#form-editar-modulo button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-modulo")[0].reset();
                $("#form-editar-modulo button").prop('disabled', false);
                criaAlerta(0, "Modulo editado com sucesso!",5000);
                recarregar();
            }
        });
    }

    function criar(){
        var form = new FormData($("#form-criar-modulo")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'modulos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar Modulo!",5000);
                $("#form-criar-modulo button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-modulo")[0].reset();
                $("#form-criar-modulo button").prop('disabled', false);
                criaAlerta(0, "Modulo criado com sucesso!",5000);
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
                url: 'modulos-lista2',
                dataSrc: ''
            },
            columns: [
                {data: 'modulo_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'modulo_nome', width: "100px"},
                {data: null, width: "300px", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                    return row.ua.curso.curso_nome + ' - ' + row.ua.ua_nome;
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
            $("#editar #e_modulo_id").val(data.modulo_id);
            consultar(data.modulo_id);
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
            deletar(delete_id.modulo_id);
        });
    }carregar();

    function consultar(modulo_id){
        request = $.ajax({
            url: 'modulos/'+ modulo_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",5000);
            }
        });
        request.done(function(response){
            $('#editar input[name="e_modulo_nome"]').val(response.modulo_nome);
            $('#form-editar-modulo #e_ua_id option[value="'+response.ua_id+'"]').prop("selected", true);
        });
    }

    function deletar(modulo_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'modulos/' + modulo_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao remover modulo!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Módulo removido com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                recarregar();
            }else{
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Este módulo possui aulas!");
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
            }
        });
    }
</script>
@endsection