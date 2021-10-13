@include('layouts.admin.head')
@section('titulo','Banners')

<main>
    <h3>Banners<div class="criar suave click"><span>Novo banner</span><i class="material-icons">add_circle</i></div></h3>
    <div id="banners" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Banner</td>
                    <td>Link</td>
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
            <label>Imagem (1350x500)</label>
            <input type="file" name="banner_imagem" required>
            <label>Link</label>
            <input type="text" name="banner_link" placeholder="http: //...">
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar <i class="material-icons click suave fechar">close</i></h4>
        <form id="formEditar" enctype="multipart/form-data">
            <input type="hidden" id="banner_id">
            <label>Imagem (1350x500)</label>
            <input type="file" name="banner_imagem" required>
            <label>Link</label>
            <input type="text" name="banner_link" placeholder="http: //...">
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
                url: '/admin/banners-list',
                dataSrc: ''
            },
            columns: [
                {data: 'banner_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'banner_imagem'},
                {data: 'banner_link'},
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
            consultar(data.banner_id);
        });

        var delete_id;
        $(document).on("click", ".deletar", function(){
            var data = table.row($(this).parents("tr")).data();
            delete_id = data.banner_id;
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
            url: '/admin/banners/' + id,
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
                $('#formEditar #banner_id').val(data.banner_id);
                $('#formEditar input[name="banner_link"]').val(data.banner_link);
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
            url: '/admin/banners',
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
            url: '/admin/banners/' + $("#banner_id").val(),
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
            url: '/admin/banners/' + id,
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