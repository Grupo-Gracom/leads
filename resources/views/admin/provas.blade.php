@extends('layouts/admin/header/header')
@section('titulo','Provas | Portal do Aluno')
@section('conteudo')
<main>
<div id="provas" class="box">
        <h3>
            Provas
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Nova Prova<span></div>
        </h3>
        <div class="clear"></div>
        <table id="tProvas" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Nome da Prova</td>
                    <td class="mini-title upper">Código da Prova</td>
                    <td class="mini-title upper">Modulo</td>
                    <td class="mini-title upper">Nível da Prova</td>
                    <td class="mini-title upper">Qual Turma?</td>
                    <td class="mini-title upper">Qual Professor?</td>
                    
                    <td class="mini-title upper">Qual Status?</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div id="criar" class="content suave">
        <h4>Criar Prova <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-prova">
            <label for="prova_nome">Nome Prova</label>
            <input type="text" name="prova_nome" id="prova_nome" placeholder="Nome da Prova" required>
            <label for="prova_codigo">Código da Prova</label>
            <input type="text" name="prova_codigo" id="prova_codigo" placeholder="Código da Prova" required>
            <label for="modulo">Qual o Modulo ?</label>
                <select name="modulo" id="modulo">
                  @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome}}</option>
                @endforeach
            </select>
            <label for="prova_nivel">Nível da Prova</label>
            <input type="number" name="prova_nivel" id="prova_nivel" placeholder="Nível da Prova Ex: 1, 2 ou 3" required>
            <label for="turma">Qual a Turma ?</label>
                <select name="turma" id="turma">
                  @foreach($turmas as $turma)
                    <option value="{{$turma->turma_id}}">{{$turma->turma_nome}}</option>
                @endforeach
            </select>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar Prova <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-prova">
        <input type="hidden" name="e_prova_id" id="e_prova_id" value="">
            <label for="e_prova_nome">Nome Prova</label>
            <input type="text" name="e_prova_nome" id="e_prova_nome" placeholder="Nome da Prova" required>
            <label for="e_prova_codigo">Código da Prova</label>
            <input type="text" name="e_prova_codigo" id="e_prova_codigo" placeholder="Código da Prova" required>
            <label for="e_modulo">Qual o Modulo ?</label>
                <select name="e_modulo" id="e_modulo">
                  @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome}}</option>
                @endforeach
            </select>
            <label for="e_prova_nivel">Nível da Prova</label>
            <input type="number" name="e_prova_nivel" id="e_prova_nivel" placeholder="Nível da Prova Ex: 1, 2 ou 3" required>
            <label for="e_turma">Qual a Turma ?</label>
                <select name="e_turma" id="e_turma">
                  @foreach($turmas as $turma)
                    <option value="{{$turma->turma_id}}">{{$turma->turma_nome}}</option>
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
    $("#form-criar-prova").submit(function(e){
        e.preventDefault();
        $("#form-criar-prova button").prop('disabled', true);
        criar();
    });

    function criar(){
        var form = new FormData($("#form-criar-prova")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'provas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar Prova!",5000);
                $("#form-criar-prova button").prop('disabled', false);
                
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-prova")[0].reset();
                $("#form-criar-prova button").prop('disabled', false);
                criaAlerta(0, "Prova criada com sucesso!",5000);
                recarregar();
            }else if(response == "3"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-prova")[0].reset();
                $("#form-criar-prova button").prop('disabled', false);
                criaAlerta(0, "Opss ja existe uma prova cadastrada com esse código!",5000);
            
            }else{
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-prova")[0].reset();
                $("#form-criar-prova button").prop('disabled', false);
                criaAlerta(0, "Prova atualizada com sucesso!",5000);
                recarregar();
            }
        });
    }

    function recarregar(){
        table.ajax.reload();
    }

    $(document).on("click", ".editar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #editar").addClass("active");
            $("#editar #e_prova_id").val(data.prova_id);
            consultar(data.prova_id);
    });

    $("#form-editar-prova").submit(function(e){
        e.preventDefault();
        $("#form-editar-prova button").prop('disabled', true);
        editar();
    });

    function editar(){
        var form = new FormData($("#form-editar-prova")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'editarProva',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao editar Prova!",5000);
                $("#form-editar-prova button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-prova")[0].reset();
                $("#form-editar-prova button").prop('disabled', false);
                criaAlerta(0, "Prova editada com sucesso!",5000);
                recarregar();
            }else if(response == "3"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-prova")[0].reset();
                $("#form-editar-prova button").prop('disabled', false);
                criaAlerta(0, "Opss ja existe uma prova cadastrada com esse código!",5000);
            
            }
        });
    }

    $(document).on("click", ".deletar", function(){
        var data = table.row($(this).parents("tr")).data();
        $("#alerta p").empty();
        $("#alerta p").text("Deseja realmente deletar esta Prova ?");
        $("#alerta .opcoes").removeClass("hide");
        $("#alerta").addClass("active");
        $("#alerta .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(data.prova_id);
            recarregar();
        });
    });

    $("#alerta .cancelar").click(function(){
        $("#alerta").removeClass("active");
    });

    function deletar(prova_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'deletar-prova/' + prova_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao deletar questão!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Prova deletada com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                recarregar();
            }
        });
    }

    function consultar(prova_id){
        request = $.ajax({
            url: 'editar-prova/' + prova_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",2000);
            }
        });
        request.done(function(response){
            $('#form-editar-prova input[name="e_prova_id"]').val(response.prova_id);
            $('#form-editar-prova input[name="e_prova_nome"]').val(response.prova_nome);
            $('#form-editar-prova input[name="e_prova_codigo"]').val(response.prova_codigo);
            $('#form-editar-prova #e_modulo option[value="'+response.modulo_id+'"]').prop("selected", true);
            $('#form-editar-prova input[name="e_prova_nivel"]').val(response.prova_nivel);
            $('#form-editar-prova #e_turma option[value="'+response.id_turma+'"]').prop("selected", true);
        });
    }

 var table;
    function carregar(){
        table = $('#tProvas').DataTable({
            ajax: {
                url: 'provas-lista',
                dataSrc: ''
            },
            columns: [
                {data: 'prova_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'prova_nome'},
                {data: 'prova_codigo'},
                {data: 'modulo.modulo_nome',defaultContent: 'indefinido'},
                {data: 'prova_nivel'},
                {data: 'turma.turma_nome',defaultContent: 'indefinido'},
                {data: 'professor.name',defaultContent: 'indefinido'},
                {data: 'prova_status', width: "100px", className: 'dt-body-center dt-head-center',
                    render: function (data, type, row) {
                        if (data == 1) {
                            return 'Sim';
                        }else{
                            return 'Não';
                        }
                    }
                },
                {data: 'acoes', width: "200px", className: 'dt-body-center dt-head-center'}
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
    }carregar();
</script>
@endsection