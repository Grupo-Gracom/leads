@include('layouts.admin.head')
@section('titulo','Publicações')

<main>
    <h3>Publicações<div class="click suave criar"><span>Novo post</span><i class="material-icons">add_circle</i></div></h3>
    <div id="posts" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Titulo</td>
                    <td>Tags</td>
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
        <form id="formCriar">
            <label>Título</label>
            <input type="text" name="post_titulo" placeholder="Título do post" required>
            <label>Conteúdo</label>
            <input type="text" name="post_texto" placeholder="Descrição do post" required>
            <label>Tags</label>
            <input type="text" name="post_tags" placeholder="tags" required>
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4>Editar <i class="material-icons click suave fechar">close</i></h4>
        <form id="formEditar">
        <label>Título</label>
            <input type="hidden" id="post_id">
            <input type="text" name="post_titulo" placeholder="Título do post" required>
            <label>Conteúdo</label>
            <input type="text" name="post_texto" placeholder="Descrição do post" required>
            <label>Tags</label>
            <input type="text" name="post_tags" placeholder="tags" required>
            <button type="submit" class="click suave"><span>Salvar</span> <i class="material-icons">save</i></button>
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
                url: '/admin/posts-list',
                dataSrc: ''
            },
            columns: [
                {data: 'post_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'post_titulo',
                    render: function (data, type, row) {
                        if(data.length > 30){
                            return data.substr(0, 30) + "...";
                        }else{
                            return data;
                        }
                    }
                },
                {data: 'post_tags', width: "100px", className: 'dt-body-center dt-head-center'},
                // {data: 'empresa_status', width: "80px", className: 'dt-body-center dt-head-center',
                //     render: function (data, type, row) {
                //         if(data == 1){
                //             return 'Ativo';
                //         }else{
                //             return 'Inativo';
                //         }
                //     }
                // },
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

        var edit_id;
        $(document).on("click", ".editar", function(){
            var data = table.row($(this).parents("tr")).data();
            edit_id = data.post_id;
            $("#lateral, #editar").addClass("active");
            consultar(edit_id);
        });

        var delete_id;
        $(document).on("click", ".deletar", function(){
            var data = table.row($(this).parents("tr")).data();
            delete_id = data.post_id;
            $("#confirmar").addClass("active");
        });

        $("#confirmar .confirmar").click(function(){
            $(this).prop('disabled', true);
            deletar(delete_id);
        });

    } carregar();

    function recarregar(){
        table.ajax.reload(null, false);
    }
    
    function criar(){
        var form = new FormData($("#formCriar")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/posts',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                $("#formCriar button span").text('Salvar');
                alerta("Falha ao criar registro!");
            },
            success: function(data, textStatus, xhr){
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

    function consultar(id){
        request = $.ajax({
            url: '/admin/posts/' + id,
            type: 'get',
            error: function(){
                alerta("Falha na consulta!");
            },
            success: function(data, textStatus, xhr){
                $('#formEditar #post_id').val(data.post_id);
                $('#formEditar input[name="post_titulo"]').val(data.post_titulo);
                $('#formEditar input[name="post_texto"]').val(data.post_texto);
                $('#formEditar input[name="post_tags"]').val(data.post_tags);
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
            url: '/admin/posts/' + $('#post_id').val(),
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                $("#formEditar button span").text('Salvar');
                alerta("Falha ao editar registro!");
            },
            success: function(data, textStatus, xhr){
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
            url: '/admin/posts/' + id,
            type: 'delete',
            error: function(){
                alerta("Falha ao deletar registro!");
            },
            success: function(response){
                if(response == "1"){
                    $("#confirmar").removeClass("active");
                    $("#confirmar .confirmar").prop('disabled', false);
                    alerta("Registro deletado com sucesso!");
                    recarregar();
                }
            }
        });
    }
    
</script>

@include('layouts.admin.foot')