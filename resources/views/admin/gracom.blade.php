@include('layouts.admin.head')
@section('titulo','Depoimentos')

<main>
    <h3>Leads Gracom</h3>
    <div id="depoimentos" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Autor</td>
                    <td>Tipo</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>

<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="criar" class="content suave">
        <h4>Criar <i class="material-icons click suave fechar">close</i></h4>
        <form id="formCriar" enctype="multipart/form-data">
            <label>Imagem</label>
            <input type="file" name="depoimento_imagem" required>
            <label>Frase</label>
            <input type="text" name="depoimento_frase" placeholder="Depoimento" required>
            <label>Autor</label>
            <input type="text" name="depoimento_autor" placeholder="Autor" required>
            <label>Tipo</label>
            <select name="depoimento_tipo">
                <option value="1">aluno</option>
                <option value="2">franqueado</option>
            </select>
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar <i class="material-icons click suave fechar">close</i></h4>
        <form id="formEditar" enctype="multipart/form-data">
            <input type="hidden" id="depoimento_id">
            <label>Imagem</label>
            <input type="file" name="depoimento_imagem">
            <label>Frase</label>
            <input type="text" name="depoimento_frase" placeholder="Depoimento" required>
            <label>Autor</label>
            <input type="text" name="depoimento_autor" placeholder="Autor" required>
            <label>Tipo</label>
            <select name="depoimento_tipo">
                <option value="1">aluno</option>
                <option value="2">franqueado</option>
            </select>
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
                url: '/admin/depoimentos-list',
                dataSrc: ''
            },
            columns: [
                {data: 'depoimento_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'depoimento_autor'},
                {data: 'depoimento_tipo'},
                {data: ''},
            ],
            columnDefs: [
                {
                    width: "100px",
                    className: 'dt-body-center dt-head-center',
                    targets: -1,
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

        $(document).on("click", ".editar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #editar").addClass("active");
            consultar(data.depoimento_id);
        });

        var delete_id;
        $(document).on("click", ".deletar", function(){
            var data = table.row($(this).parents("tr")).data();
            delete_id = data.depoimento_id;
            $("#confirmar").addClass("active");
        });

        $("#confirmar .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(delete_id);
        });

        $('#tabela').addClass("active");

    } carregar();

    function recarregar(){
        table.ajax.reload();
    }

    function consultar(id){
        request = $.ajax({
            url: '/admin/depoimentos/' + id,
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
                $('#formEditar #depoimento_id').val(data.depoimento_id);
                $('#formEditar input[name="depoimento_frase"]').val(data.depoimento_frase);
                $('#formEditar input[name="depoimento_autor"]').val(data.depoimento_autor);
                $('#formEditar select[name="depoimento_tipo"] option[value="'+data.depoimento_tipo+'"]').attr("selected", "selected");
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
            url: '/admin/depoimentos',
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
            url: '/admin/depoimentos/' + $("#depoimento_id").val(),
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
            url: '/admin/depoimentos/' + id,
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