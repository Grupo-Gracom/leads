@include('layouts/header/header')

<main>
    <div id="cronogramas" class="box">
        <h3>
            Cronogramas
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Novo cronograma<span></div>
        </h3>
        <ul class="list-head">
            <li>
                <div><h6 class="mini-title upper">#</h6></div>
                <div><h6 class="mini-title upper">Cronograma</h6></div>
                <div><h6 class="mini-title upper">Ações</h6></div>
            </li>
        </ul>
        <ul class="list-body loading active"></ul>
    </div>
</main>

<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="criar" class="content suave">
        <h4 class="barlow">Criar cronograma <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-cronograma" method="post">
            <label for="cronograma_nome">Nome</label>
            <input type="text" name="cronograma_nome" id="cronograma_nome" placeholder="Nome do cronograma" required>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4 class="barlow">Editar cronograma <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-cronograma" method="post">
            <input type="hidden" name="e_cronograma_id" id="e_cronograma_id" value="">
            <label for="e_cronograma_nome">Nome</label>
            <input type="text" name="e_cronograma_nome" id="e_cronograma_nome" placeholder="Nome do cronograma" required>
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

    $(document).on("click", ".checkbox", function(){
        if($(this).find("input").prop("checked")){
            $(this).addClass("active");
        }else{
            $(this).removeClass("active");
        }
    });

    function carregarLista(){
        $("#cronogramas .list-body").load("cronogramas-lista", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $(this).removeClass("active");
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Erro: " + xhr.status + ": " + xhr.statusText, 2000);
            }
        });
    } carregarLista();

    $(".criar").click(function(){
        $("#lateral, #criar").addClass("active");
    });
    
    $("#form-criar-cronograma").submit(function(e){
        e.preventDefault();
        $("#form-criar-cronograma button").prop('disabled', true);
        criar();
    });

    $(document).on("click", ".editar", function(){
        $("#lateral, #editar").addClass("active");
        cronograma_id = $(this).attr("data-id");
        consultar(cronograma_id);
    });

    $("#form-editar-cronograma").submit(function(e){
        e.preventDefault();
        $("#form-editar-cronograma button").prop('disabled', true);
        editar();
    });

    $(document).on("click", ".deletar", function(){
        var cronograma_id = $(this).attr("data-id");
        $("#alerta p").empty();
        $("#alerta p").text("Deseja realmente deletar este cronograma ?");
        $("#alerta .opcoes").removeClass("hide");
        $("#alerta").addClass("active");
        $("#alerta .confirmar").attr("modelo","cronograma");
        $("#alerta .confirmar").attr("cronograma_id", cronograma_id);
    });

    $("#alerta .confirmar").click(function(){
        $(this).prop('disabled', true);
        deletar($(this).attr("cronograma_id"));
        $(this).removeAttr('modelo');
        $(this).removeAttr('cronograma_id');
    });
    
    $("#lateral .fechar").click(function(){
        $("#lateral, #lateral .content").removeClass("active");
    });

    $("#alerta .cancelar").click(function(){
        $("#alerta").removeClass("active");
    });
    
    function criar(dias){
        var form = new FormData($("#form-criar-cronograma")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cronogramas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar cronograma!",5000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-cronograma")[0].reset();
                $("#form-criar-cronograma button").prop('disabled', false);
                criaAlerta(0, "Cronograma criado com sucesso!",5000);
                carregarLista();
            }
        });
    }

    function consultar(cronograma_id){
        request = $.ajax({
            url: 'cronogramas/' + cronograma_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",2000);
            }
        });
        request.done(function(response){
            $("#form-editar-cronograma .checkbox").removeClass("active");
            $('#form-editar-cronograma input[name="e_cronograma_id"]').val(response.cronograma_id);
            $('#form-editar-cronograma input[name="e_cronograma_nome"]').val(response.cronograma_nome);
        });
    }
    
    function editar(dias){
        var form = new FormData($("#form-editar-cronograma")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cronogramas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0,"Falha ao editar cronograma!",2000);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-cronograma")[0].reset();
                $("#form-editar-cronograma button").prop('disabled', false);
                criaAlerta(0, "Cronograma atualizado com sucesso!",5000);
                carregarLista();
            }
        });
    }

    function deletar(cronograma_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'cronogramas/' + cronograma_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao deletar cronograma!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Cronograma deletado com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                carregarLista();
            }else{
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Este cronograma possui cursos atrelados a ele, remova seus cursos primeiro!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 5000);
            }
        });
    }
    
    

</script>

