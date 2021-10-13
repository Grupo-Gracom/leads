@extends('layouts/admin/header/header')
@section('titulo','Professores | Portal do Aluno')
@section('conteudo')
<main>
<div class="box filtro">
        <h3>
        Busca:
   <span>
    <input type="text" name="busca" id="busca" class="filtro-notas" placeholder="ex: nome ou email">
    </span>
   </h3>
    </div>
<div id="professores" class="box margin-topo">
        <h3>
            Professores
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Novo Professor<span></div>
        </h3>
        <table id="tProfessores" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Nome</td>
                    <td class="mini-title upper">Email</td>
                    <td class="mini-title upper">Qual Unidade?</td>
                    <td class="mini-title upper">Código?</td>
                    <td class="mini-title upper">Ativo?</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div id="criar" class="content suave">
        <h4>Criar Professor <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-professor">
            <label for="codigo">Código</label>
            <input type="text" name="matricula" id="codigo" placeholder="Código de Acesso" required>
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" placeholder="Nome do Professor" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Email do Professor" required>
            <label for="password">Senha </label>
            <input type="password" name="password" id="password" placeholder="Senha do Professor" required>
            <label for="unidade">Qual Unidade ?</label>
                <select name="unidade" id="unidade">
                  @foreach($unidades as $unidade)
                    <option value="{{$unidade->id_unidade}}">{{$unidade->unidade_nome}}</option>
                @endforeach
                </select>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar Professor <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-professor">
           <label for="codigo">Código</label>
            <input type="text" name="e_matricula" id="codigo" placeholder="Código de Acesso" required>
            <input type="hidden" name="e_user_id" id="e_user_id" value="" required>
            <label for="e_name">Nome</label>
            <input type="text" name="e_name" id="e_name" placeholder="Nome do Professor" required>
            
            <label for="e_email">Email</label>
            <input type="email" name="e_email" id="e_email" placeholder="Email do Professor" required>
            
            <label for="e_password">Senha </label>
            <input type="password" name="e_password" id="e_password" placeholder="Senha do Professor">
            
            <label for="e_unidade">Qual Unidade ?</label>
                <select name="e_unidade" id="e_unidade">
                  @foreach($unidades as $unidade)
                    <option value="{{$unidade->id_unidade}}">{{$unidade->unidade_nome}}</option>
                @endforeach
                </select>
            
            <label for="e_status">Ativo ?</label>
                <select name="e_status" id="e_status">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
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
     $('#busca').on( 'keyup', function () {
    table.search( this.value ).draw();
} );
    $(".criar").click(function(){
        $("#lateral, #criar").addClass("active");
    });
    $("#lateral .fechar").click(function(){
        $("#lateral, #lateral .content").removeClass("active");
    });

    $("#alerta .cancelar").click(function(){
        $("#alerta").addClass("hide");
    });

    $("#form-criar-professor").submit(function(e){
        e.preventDefault();
        $("#form-criar-professor button").prop('disabled', true);
        criar();
    });

    $("#form-editar-professor").submit(function(e){
        e.preventDefault();
        $("#form-editar-professor button").prop('disabled', true);
        editar();
    });

    function criar(){
        var form = new FormData($("#form-criar-professor")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'professores',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar Professor!",5000);
                $("#form-criar-professor button").prop('disabled', false);
                
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-professor")[0].reset();
                $("#form-criar-professor button").prop('disabled', false);
                criaAlerta(0, "Professor criado com sucesso!",5000);
                recarregar();
            }
        });
    }

    $(document).on("click", ".editar", function(){
        var data = table.row($(this).parents("tr")).data();
        $("#lateral, #editar").addClass("active");
        consultar(data.id);
    });
    
    $(document).on("click", ".deletar", function(){
        var data = table.row($(this).parents("tr")).data();
        $("#alerta p").empty();
        $("#alerta p").text("Deseja realmente deletar este Professor ?");
        $("#alerta .opcoes").removeClass("hide");
        $("#alerta").addClass("active");
        $("#alerta .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(data.id);
        });
    });

    function consultar(user_id){
        request = $.ajax({
            url: 'editar-professor/' + user_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",2000);
            }
        });
        request.done(function(response){
            $('#form-editar-professor input[name="e_user_id"]').val(response.id);
            $('#form-editar-professor input[name="e_name"]').val(response.name);
            $('#form-editar-professor input[name="e_email"]').val(response.email);
            $('#form-editar-professor input[name="e_matricula"]').val(response.matricula);
            $('#form-editar-professor input[name="e_password"]').val(response.password);
            $('#form-editar-professor #e_unidade option[value="'+response.unidade_id+'"]').prop("selected", true);
            $('#form-editar-professor #e_status option[value="'+response.status+'"]').prop("selected", true);
        });
    }

    function editar(){
        var form = new FormData($("#form-editar-professor")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'professores',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0,"Falha ao editar Professor!",2000);
                $("#form-editar-professor button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-professor")[0].reset();
                $("#form-editar-professor button").prop('disabled', false);
                criaAlerta(0, "Professor atualizado com sucesso!",5000);
                recarregar();
            }
        });
    }

    function deletar(user_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'deletar-professor/' + user_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao deletar Professor!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Professor deletado com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(() => {
                    $("#alerta").removeClass("active");
                }, 2000);
                recarregar();
            }else{
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Este Professor possue turmas atrelados a ele favor modificar responsavel da turma!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 5000);
            }
        });
    }

    function recarregar(){
        table.ajax.reload();
    }

 var table;
    function carregar(){
        table = $('#tProfessores').DataTable({
            ajax: {
                url: 'professores-lista',
                dataSrc: ''
            },
            columns: [
                {data: 'id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'name'},
                {data: 'email', width: "200px", className: 'dt-body-center dt-head-center'},
                {data: 'unidade.unidade_nome'},
                {data: 'matricula'},
                {data: 'status', width: "100px", className: 'dt-body-center dt-head-center',
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
                    <?php if(Auth::user()->cargo_id == 1 || Auth::user()->cargo_id == 4){ ?>
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