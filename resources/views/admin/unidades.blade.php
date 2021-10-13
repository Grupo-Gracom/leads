@include('layouts.admin.head')
@section('titulo','Unidades')

<main>
    <h3>Unidades<div class="criar suave click"><span>Nova unidade</span><i class="material-icons">add_circle</i></div></h3>
    <div id="unidades" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Unidade</td>
                    <td class="mini-title upper">Telefone</td>
                    <td class="mini-title upper">CEP</td>
                    <td class="mini-title upper">Cód</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div id="criar" class="content suave">
        <h4>Criar Unidade <i class="material-icons click suave fechar">close</i></h4>
        <form id="formCriar">
            <label>Nome</label>
            <input type="text" name="unidade_nome" placeholder="Nome da Unidade" required>
            <label>Endereço</label>
            <input type="text" name="unidade_endereco" placeholder="Endereço da Unidade" required>
            <label>CEP</label>
            <input type="text" name="unidade_cep" placeholder="CEP da Unidade" required>
            <label>Telefone</label>
            <input type="text" name="unidade_telefone" placeholder="Telefone da Unidade" required>
            <label>Código Sophia</label>
            <input type="number" name="unidade_sophia" placeholder="Código do Sophia" required>
            <input type="hidden" name="unidade_status" value="1">
            <div class="clear"></div>
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar Unidade <i class="material-icons click suave fechar">close</i></h4>
        <form id="formEditar">
            <input type="hidden" id="unidade_id">
            <label>Nome</label>
            <input type="text" name="unidade_nome" placeholder="Nome da Unidade" required>
            <label>Endereço</label>
            <input type="text" name="unidade_endereco" placeholder="Endereço da Unidade" required>
            <label>CEP</label>
            <input type="text" name="unidade_cep" placeholder="CEP da Unidade" required>
            <label>Telefone</label>
            <input type="text" name="unidade_telefone" placeholder="Telefone da Unidade" required>
            <label>Código Sophia</label>
            <input type="number" name="unidade_sophia" placeholder="Código do Sophia" required>
            <div class="clear"></div>
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
        </form>
    </div>
</div>

<div id="confirmar" class="suave">
    <p>Deseja realmente deletar este item?</p>
    <div class="opcoes right-align hide">
        <button class="mini-title upper click suave confirmar">sim</button>
        <button class="mini-title upper click suave cancelar">não</button>
    </div>
</div>

<script>

    $('input[name="unidade_cep"]').mask("00000-000");
    $('input[name="unidade_telefone"]').mask("(00) 0000-0000");

    $(".criar").click(function(){
        $("#lateral, #criar").addClass("active");
    });

    $("#formCriar").submit(function(e){
        e.preventDefault();
        $("#formCriar button").prop('disabled', true);
        $("#formCriar button span").text('Aguarde...');
        criar();
    });

    $("#formEditar").submit(function(e){
        e.preventDefault();
        $("#formEditar button").prop('disabled', true);
        $("#formEditar button span").text('Aguarde...');
        editar();
    });
    
    $("#lateral .fechar").click(function(){
        $("#lateral, #lateral .content").removeClass("active");
        $("#formCriar")[0].reset();
        $("#formEditar")[0].reset();
    });

    $("#confirmar .cancelar").click(function(){
        $("#confirmar").removeClass("active");
    });
    
    var table;
    function carregar(){
        table = $('#tabela').DataTable({
            ajax: {
                url: '/admin/unidades-list',
                dataSrc: ''
            },
            columns: [
                {data: 'unidade_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'unidade_nome'},
                {data: 'unidade_telefone', width: "120px", className: 'dt-body-center dt-head-center'},
                {data: 'unidade_cep', width: "100px", className: 'dt-body-center dt-head-center'},
                {data: 'unidade_sophia', width: "80px", className: 'dt-body-center dt-head-center'},
                {data: 'acoes', width: "80px", className: 'dt-body-center dt-head-center'}
            ],
            columnDefs: [
                {
                    targets: -1,
                    width: "80px",
                    className: 'dt-body-center dt-head-center',
                    data: null,
                    defaultContent: '<i class="material-icons click suave editar">create</i><i class="material-icons click suave deletar">delete</i>'
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

        var edit_id;
        $(document).on("click", ".editar", function(){
            var data = table.row($(this).parents("tr")).data();
            edit_id = data.unidade_id;
            $("#lateral, #editar").addClass("active");
            consultar(edit_id);
        });

        var delete_id;
        $(document).on("click", ".deletar", function(){
            var data = table.row($(this).parents("tr")).data();
            delete_id = data.unidade_id;
            $("#confirmar").addClass("active");
        });

        $("#confirmar .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(delete_id);
        });
    }carregar();
    
    function recarregar(){
        table.ajax.reload();
    }

    function consultar(id){
        request = $.ajax({
            url: '/admin/unidades/' + id,
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
                $('#formEditar #unidade_id').val(data.unidade_id);
                $('#formEditar input[name="unidade_nome"]').val(data.unidade_nome);
                $('#formEditar input[name="unidade_endereco"]').val(data.unidade_endereco);
                $('#formEditar input[name="unidade_telefone"]').val(data.unidade_telefone);
                $('#formEditar input[name="unidade_cep"]').val(data.unidade_cep);
                $('#formEditar input[name="unidade_sophia"]').val(data.unidade_sophia);
            },
            complete: function(xhr, textStatus) {} 
        });
    }

    function criar(){
        var form = new FormData($("#formCriar")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/unidades',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                $("#formCriar button span").text('Salvar');
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr) {
                $("#lateral, #lateral .content").removeClass("active");
                $("#formCriar")[0].reset();
                $("#formCriar button").prop('disabled', false);
                $("#formCriar button span").text('Salvar');
                alerta("Registro criado com sucesso!");
                recarregar();
            },
            complete: function(xhr, textStatus) {} 
        });
    }

    function editar(){
        var form = new FormData($("#formEditar")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/unidades/' + $("#unidade_id").val(),
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                $("#formEditar button span").text('Salvar');
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr) {
                $("#lateral, #lateral .content").removeClass("active");
                $("#formEditar")[0].reset();
                $("#formEditar button").prop('disabled', false);
                $("#formEditar button span").text('Salvar');
                alerta("Registro atualizado com sucesso!");
                recarregar();
            },
            complete: function(xhr, textStatus) {} 
        });
    }
    
    function deletar(id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/unidades/' + id,
            type: 'delete',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
                $("#confirmar").removeClass("active");
                $("#confirmar .confirmar").prop('disabled', false);
                alerta("Registro deletado com sucesso!");
                recarregar();
            },
            complete: function(xhr, textStatus) {} 
        });
    }

    

    

    
    
</script>
