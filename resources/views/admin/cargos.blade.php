@extends('layouts/admin/header/header')
@section('titulo','Cargos | Portal do Aluno')
@section('conteudo')
<main>
<div id="cargos" class="box">
        <h3>
            Cargos
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Novo Cargo<span></div>
        </h3>
        <div class="clear"></div>
        <table id="tCargos" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Cargos</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div id="criar" class="content suave">
        <h4>Criar Cargos <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-cargo">
            <label for="cargo_nome">Cargo</label>
            <input type="text" name="cargo_nome" id="cargo_nome" placeholder="Nome do Cargo" required>
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
    $("#form-criar-cargo").submit(function(e){
        e.preventDefault();
        $("#form-criar-cargo button").prop('disabled', true);
        criar();
    });

    function criar(){
        var form = new FormData($("#form-criar-cargo")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cargos',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar Cargo!",5000);
                $("#form-criar-cargo button").prop('disabled', false);
                
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-cargo")[0].reset();
                $("#form-criar-cargo button").prop('disabled', false);
                criaAlerta(0, "Cargo criado com sucesso!",5000);
                recarregar();
            }
        });
    }

    function recarregar(){
        table.ajax.reload();
    }
 var table;
    function carregar(){
        table = $('#tCargos').DataTable({
            ajax: {
                url: 'cargos-lista',
                dataSrc: ''
            },
            columns: [
                {data: 'cargo_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'cargo_nome'},
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