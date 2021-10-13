@extends('layouts/admin/header/header')
@section('titulo','Turmas | Portal do Aluno')
@section('conteudo')
<main>
@if(Auth::user()->cargo_id == 1 || Auth::user()->cargo_id == 4 )
<div class="box filtro">
        <h3>
        Unidade:
    <span><select id="unidade" class="filtro-notas">
<option value="">Todas as Unidades</option>
@foreach($unidades as $unidade)
<option>{{$unidade->unidade_nome}}</option>
@endforeach
</select>
   </h3>
    </div>
    @endif
    <div class="box margin-topo">
        <h3>
            Turmas
            <div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Nova Turma<span></div>
        </h3>
        <div class="clear"></div>
        <table id="tTurmas" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Turma</td>
                    <td class="mini-title upper">Status</td>
                    <td class="mini-title upper">Unidade</td>
                    <td class="mini-title upper">Professor</td>
                    <td class="mini-title upper">Dia da Semana</td>
                    <td class="mini-title upper">Abertura/Termino</td>
                    <td class="mini-title upper">Modulo Atual</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="visualizar" class="content suave" style="padding: 0;">
        <h4 class="barlow" style="position: absolute;right: 16px;top: 16px;"><i class="material-icons click suave fechar">close</i></h4>
        <div class="conteudo"></div>
    </div>
    <div id="criar" class="content suave">
        <h4 class="barlow">Criar turma <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-turma" action="" method="post" enctype="multipart/form-data">
            <label for="turma_nome">Nome</label>
            <input type="text" name="turma_nome" id="turma_nome" placeholder="Nome da turma" required>
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="curso_id">Curso</label>
                <select name="curso_id" id="curso_id">
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->curso_id }}">{{ $curso->curso_nome }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->cargo_id != 2)
            <div class="metade direita">
                <label for="professor_id">Professor</label>
                <select name="professor_id" id="professor_id">
                    @foreach($professores as $professor)
                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                    @endforeach
                </select>
            </div>
            @else
             <input type="hidden" value="{{ Auth::user()->id }}" name="professor_id" id="professor_id">
            @endif
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="turma_periodo">Período</label>
                <select name="turma_periodo" id="turma_periodo">
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                </select>
            </div>
            <div class="metade direita">
                <label for="turma_status">Situação ?</label>
                <select name="turma_status" id="turma_status">
                    <option value="1">Em formação</option>
                    <option value="2">Vigente</option>
                    <option value="3">Finalizada</option>
                    <option value="4">Desativada</option>
                </select>
            </div>
            <div class="clear"></div>
            @if(Auth::user()->cargo_id != 2)
            <div class="metade esquerda">
                <label for="unidade_id">Unidade</label>
                <select name="unidade_id" id="unidade_id">
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id_unidade }}">{{ $unidade->unidade_nome }}</option>
                    @endforeach
                </select>
            </div>
            @else
                <input type="hidden" value="{{ Auth::user()->unidade_id }}" name="unidade_id" id="unidade_id">
            @endif
            <div class="metade direita">
                <label for="data_abertura">Data de Abertura</label>
                <input type="date" name="data_inicio" id="data_inicio" placeholder="Ex: 00/00/0000" required>
               
            </div>
            <div class="metade esquerda">
                <label for="data_encerramento">Data de Encerramento</label>
                <input type="date" name="data_encerramento" id="data_encerramento" placeholder="Ex: 00/00/0000" required>
            </div>
            <div class="metade direita">
                <label for="horario">Horário</label>
                <input type="text" name="horario" id="horario" placeholder="Ex: 00h00 ás 00h00" required>
            </div>
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="turma_modulo">Qual Modulo?</label>
                <select name="turma_modulo" id="turma_modulo">
                   @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class="metade direita">
                <label for="dia_semana">Qual dia da Semana?</label>
                <select name="dia_semana" id="dia_semana">
                    <option value="1">Segunda-Feira</option>
                    <option value="2">Terça-Feira</option>
                    <option value="3">Terça-Feira / Quinta Feira</option>
                    <option value="4">Quarta-Feira</option>
                    <option value="5">Quarta-Feira / Sexta Feira</option>
                    <option value="6">Quinta-Feira</option>
                    <option value="7">Sexta-Feira</option>
                    <option value="8">Sábado</option>
                </select>
            </div>
            <div class="metade esquerda">
                <label for="horario">Qual Duração Aula?</label>
                <input type="text" name="hora_aula" id="hora_aula" placeholder="Ex: 60" required>
            </div>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="editar" class="content suave">
        <h4 class="barlow">Editar turma <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-editar-turma" action="" method="post">
            <input type="hidden" name="e_turma_id" id="e_turma_id" value="">
            <label for="e_turma_nome">Nome</label>
            <input type="text" name="e_turma_nome" id="e_turma_nome" placeholder="Nome da turma" required>
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="e_curso_id">Curso</label>
                <select name="e_curso_id" id="e_curso_id">
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->curso_id }}">{{ $curso->curso_nome }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->cargo_id != 2)
            <div class="metade direita">
                <label for="e_professor_id">Professor</label>
                <select name="e_professor_id" id="e_professor_id">
                    @foreach($professores as $professor)
                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                    @endforeach
                </select>
            </div>
            @else
            <input type="hidden" value="{{ Auth::user()->id }}" name="e_professor_id" id="e_professor_id">
            @endif
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="e_turma_periodo">Período</label>
                <select name="e_turma_periodo" id="e_turma_periodo">
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                </select>
            </div>
            <div class="metade direita">
                <label for="e_turma_status">Situação ?</label>
                <select name="e_turma_status" id="e_turma_status">
                    <option value="1">Em formação</option>
                    <option value="2">Vigente</option>
                    <option value="3">Finalizada</option>
                    <option value="4">Desativada</option>
                </select>
            </div>
            <div class="clear"></div>
            @if(Auth::user()->cargo_id != 2)
            <div class="metade esquerda">
                <label for="e_unidade_id">Unidade</label>
                <select name="e_unidade_id" id="e_unidade_id">
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id_unidade }}">{{ $unidade->unidade_nome }}</option>
                    @endforeach
                </select>
            </div>
            @else
            <input type="hidden" value="{{ Auth::user()->unidade_id }}" name="e_unidade_id" id="e_unidade_id">
            @endif
            <div class="metade direita">
                <label for="e_data_abertura">Data de Abertura</label>
                <input type="date" name="e_data_inicio" id="e_data_inicio" placeholder="Ex: 00/00/0000" required>
               
            </div>
            <div class="metade esquerda">
                <label for="e_data_encerramento">Data de Encerramento</label>
                <input type="date" name="e_data_encerramento" id="e_data_encerramento" placeholder="Ex: 00/00/0000" required>
            </div>
            <div class="metade direita">
                <label for="e_horario">Horário</label>
                <input type="text" name="e_horario" id="e_horario" placeholder="Ex: 00h00 ás 00h00" required>
            </div>
            
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="e_turma_modulo">Qual Modulo?</label>
                <select name="e_turma_modulo" id="e_turma_modulo">
                   @foreach($modulos as $modulo)
                    <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class="metade direita">
                <label for="e_dia_semana">Qual dia da Semana?</label>
                <select name="e_dia_semana" id="e_dia_semana">
                    <option value="1">Segunda-Feira</option>
                    <option value="2">Terça-Feira</option>
                    <option value="3">Terça-Feira / Quinta Feira</option>
                    <option value="4">Quarta-Feira</option>
                    <option value="5">Quarta-Feira / Sexta Feira</option>
                    <option value="6">Quinta-Feira</option>
                    <option value="7">Sexta-Feira</option>
                    <option value="8">Sábado</option>
                </select>
            </div>
            <div class="metade esquerda">
                <label for="horario">Qual Duração Aula?</label>
                <input type="text" name="e_hora_aula" id="e_hora_aula" placeholder="Ex: 60" required>
            </div>
            <div class="clear"></div>
            <button type="submit" class="click suave">Salvar <i class="material-icons">save</i></button>
        </form>
    </div>
    <div id="adicionar" class="content suave">
        <h4 class="barlow">Adicionar alunos <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-pesquisar-alunos">
            <label for="cliente_busca">Pesquisar cliente</label>
            <input type="text" name="cliente_busca" id="cliente_busca" required>
            <input type="hidden" name="cliente_excecoes" id="cliente_excecoes">
            <input type="hidden" name="cliente_unidade_id" id="cliente_unidade_id" value="">
            <button type="submit" class="click suave">Procurar <i class="material-icons">search</i></button>
        </form>
        <form id="form-adicionar-alunos">
            <input type="hidden" name="a_turma_id" id="a_turma_id" value="">
            <div id="clientes" class="turmas">
                <ul class="list-head">
                    <li>
                        <div><h6 class="mini-title upper">#</h6></div>
                        <div><h6 class="mini-title upper">id</h6></div>
                        <div><h6 class="mini-title upper">Nome</h6></div>
                        <div><h6 class="mini-title upper">Matrícula</h6></div>
                    </li>
                </ul>
                <ul class="list-body loading"></ul upper>
            </div>
            <button type="submit" class="click suave">Adicionar <i class="material-icons">person_add</i></button>
            <div id="alunos">
                <ul class="list-head">
                    <li>
                        <div><h6 class="mini-title upper">#</h6></div>
                        <div><h6 class="mini-title upper">id</h6></div>
                        <div><h6 class="mini-title upper">Aluno</h6></div>
                        <div><h6 class="mini-title upper">Ações</h6></div>
                    </li>
                </ul>
                <ul class="list-body loading"></ul>
            </div>
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
 

$('#unidade').on('change', function(){
             table.column(4).search(this.value).draw();   
});

    $(document).on("click", ".checkbox", function(){
        if($(this).find("input").prop("checked")){
            $(this).addClass("active");
        }else{
            $(this).removeClass("active");
        }
    });

    function recarregar(){
        table.ajax.reload();
    }

    var table;
    function carregar(){
        table = $('#tTurmas').DataTable({
            ajax: {
                url: 'turmas-lista',
                dataSrc: ''
            },
            columns: [
                {data: 'turma_id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'turma_nome',width: "180px"},
                {data: 'turma_status', width: "140px", className: 'dt-body-center dt-head-center',
                    render: function (data, type, row) {
                        switch(data){
                            case 1:
                                return 'Em formação';
                            break;
                            case 2:
                                return 'Vigente';
                            break;
                            case 3:
                                return 'Finalizada';
                            break;
                            case 4:
                                return 'Desativada';
                            break;
                        
                        }
                    }
                },
                {data: 'unidade.unidade_nome', width: "220px"},
                {data: 'professor.name',width: "320px"},
                {data: 'dia_semana', width: "140px", className: 'dt-body-center dt-head-center',
                    render: function (data, type, row) {
                        switch(data){
                            case 1:
                                return 'SEG';
                            break;
                            case 2:
                                return 'TER';
                            break;
                            case 3:
                                return 'TER / QUI';
                            break;
                            case 4:
                                return 'QUA';
                            break;
                            case 5:
                                return 'QUA / SEX';
                            break;
                            case 6:
                                return 'QUI';
                            break;
                            case 7:
                                return 'SEX';
                            break;
                            case 8:
                                return 'SAB';
                            break;
                            default : 
                                return "Indefinido";
                        }
                    }
                },
                {data: null, width: "80px", "defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        var dataI = row.data_abertura;
                        var dataT = row.data_encerramento;
                        var dataFormatadaI = dataI.replace(/(\d*)-(\d*)-(\d*).*/, '$3-$2-$1');
                        var dataFormatadaT = dataT.replace(/(\d*)-(\d*)-(\d*).*/, '$3-$2-$1');

                      return dataFormatadaI +" <br> "+dataFormatadaT ;
                    }
                },
                {data: 'modulo.modulo_nome', width: "120px","defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center'},
                {data: 'acoes', width: "300px", className: 'dt-body-center dt-head-center'}
            ],
            columnDefs: [
                {
                    targets: -1,
                    width: "200px",
                    className: 'dt-body-center dt-head-center',
                    data: null,
                    <?php if(Auth::user()->cargo_id == 1){ ?>
                    defaultContent: '<i class="material-icons click suave visualizar" title="Visualizar turma">visibility</i><i class="material-icons click suave adicionar" title="Adicionar alunos">group_add</i><i class="material-icons click suave editar">create</i><i class="material-icons click suave deletar">delete</i>'
                    <?php }else{ ?>
                    defaultContent: '<i class="material-icons click suave visualizar" title="Visualizar turma">visibility</i><i class="material-icons click suave adicionar" title="Adicionar alunos">group_add</i><i class="material-icons click suave editar">create</i>'
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
        consultar(data.turma_id);

    });

        $(document).on("click", ".deletar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#alerta p").empty();
            $("#alerta p").text("Deseja realmente deletar esta turma?");
            $("#alerta .opcoes").removeClass("hide");
            $("#alerta").addClass("active");
            $("#alerta .confirmar").attr("modelo","turma");
            $("#alerta .confirmar").attr("turma_id", data.turma_id);
        });

        $(document).on("click",".adicionar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #adicionar").addClass("active");
            $("#form-adicionar-alunos #a_turma_id").val(data.turma_id);
            $("#form-pesquisar-alunos #cliente_unidade_id").val(data.unidade_id);
            carregarAlunos(data.turma_id);
        });

        $(document).on("click", ".visualizar", function(){
            var data = table.row($(this).parents("tr")).data();
            $("#lateral, #visualizar").addClass("active");
            carregarTurma(data.turma_id);
        });
        
        $("#tTurmas").css({"visibility":"visible","opacity":"1"});
    }carregar();
    
    function carregarAlunos(turma_id){
        $("#alunos .list-body").load("turma-lista/"+ turma_id, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $(this).removeClass("active");
                var excecoes = [];
                $("#alunos .list-body li").each(function(){
                    excecoes.push($(this).find("div:nth-child(2)").text());
                });
                $("#cliente_excecoes").val(excecoes);
                if($("#cliente_busca").val() != ''){
                    buscarLista($("#cliente_busca").val(), $("#cliente_unidade_id").val(), $("#cliente_excecoes").val());
                }
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Falha ao carregar alunos", 2000);
            }
        });
    }

    function carregarFrequencia(turma_id){
        $("#visualizar .list-body").load("turma-frequencia/"+ turma_id, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $(this).removeClass("active");
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Falha ao carregar alunos", 2000);
            }
        });
    }
    
    function buscarLista(busca, unidade, excecoes){
        $("#clientes .list-body").load("clientes-busca/"+ busca + '/' + unidade, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $(this).removeClass("active");
                var ids = excecoes.split(',');
                $("#clientes .list-body li").each(function(){
                    var id = parseInt($(this).find("div").text());
                    ids.forEach( e => {
                        if(id == parseInt(e)){
                            $('#clientes .list-body li[data-item="'+id+'"]').remove();
                        }
                    });
                });
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Falha ao carregar lista ", 2000);
            }
        });
    }

    function carregarTurma(turma_id){
        $("#visualizar .conteudo").load("turmas-visualizar/"+ turma_id , function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                //carregarFrequencia(turma_id);
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Falha ao carregar a turma.", 2000);
            }
        });
    }

    $(".criar").click(function(){
        $("#lateral, #criar").addClass("active");
    });
    
    $("#form-criar-turma").submit(function(e){
        e.preventDefault();
        criar();
    });

    $("#form-editar-turma").submit(function(e){
        e.preventDefault();
        $("#form-editar-turma button").prop('disabled', true);
        editar();
    });

    $(document).on("click", ".deletar-aluno", function(){
        $("#alerta p").empty();
        $("#alerta p").text("Deseja realmente remover este aluno ?");
        $("#alerta .opcoes").removeClass("hide");
        $("#alerta").addClass("active");
        $("#alerta .confirmar").attr("modelo","aluno");
        $("#alerta .confirmar").attr("aluno_id", $(this).attr("data-id"));
    });
    
    $("#alerta .confirmar").click(function(){
        $(this).prop('disabled', true);
        var modelo = $("#alerta .confirmar").attr("modelo");
        if(modelo == "turma"){
            deletar($(this).attr("turma_id"));
            $(this).removeAttr('modelo');
            $(this).removeAttr('turma_id');
            recarregar();
        }else{
            deletarAluno($(this).attr("aluno_id"), $("#a_turma_id").val());
            $(this).removeAttr('modelo');
            $(this).removeAttr('aluno_id');
        }
    });
    
    $("#form-pesquisar-alunos").submit(function(e){
        e.preventDefault();
        if($("#cliente_busca").val().length > 3){
            $("#clientes .list-body").addClass("active");
            buscarLista($("#cliente_busca").val(), $("#cliente_unidade_id").val(), $("#cliente_excecoes").val());
        }
    });
    
    $("#form-adicionar-alunos").submit(function(e){
        e.preventDefault();
        $(this).find("button").prop("disabled", true);
        adicionarAlunos();
    });
    
    $(document).on("submit", "#form-frequencia-turma", function(e){
        e.preventDefault();
        $(this).find("button").prop("disabled", true);
        var frequencia = new Array();
        $('#form-frequencia-turma input[type="checkbox"]:checked').each(function(){
            frequencia.push($(this).val());
        });
        var proxAula = 0;
        
        if($(".aula").length > 1){
            var aulas = [];
            $(".aula").each(function(){
                if($(this).hasClass("active")){
                    var aula = {"aula_id": $(this).attr("data-id"), "flag": 1}
                }else{
                    var aula = {"aula_id": $(this).attr("data-id"), "flag": 0}
                }
                aulas.push(aula);
            });
            aulas.forEach(function(value, key){
                if(value.flag == 1){
                    if((key + 1) < aulas.length){
                        proxAula = aulas[key + 1].aula_id
                    }else if((key + 1) == aulas.length){
                        proxAula = 9999;
                    }else{
                        proxAula = aulas[key].aula_id
                    }

                }
            });
        }else{
            proxAula = 9999;
        }
console.log(proxAula);
        if(frequencia.length < 1){
            criaAlerta(0, "A lista não pode estar vazia!",5000);
        }else{
            salvarFrequencia(frequencia, proxAula);
        }
    });
    
    $("#lateral .fechar").click(function(){
        $("#lateral, #lateral .content").removeClass("active");
        $("#clientes .list-body").empty();
        $("#form-pesquisar-alunos")[0].reset();
    });

    $("#alerta .cancelar").click(function(){
        $("#alerta").removeClass("active");
        $("#alerta .confirmar").prop('disabled', false);
    });

    function criar(){
        var form = new FormData($("#form-criar-turma")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'turmas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao criar turma!",5000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-criar-turma")[0].reset();
                $("#form-criar-turma button").prop('disabled', false);
                criaAlerta(0, "Turma criada com sucesso!",5000);
                recarregar();
            }
        });
    }

    function consultar(turma_id){
        request = $.ajax({
            url: 'turmas-editar/' + turma_id,
            type: 'get',
            error: function(){
                criaAlerta(0,"Falha na consulta!",2000);
            }
        });
        request.done(function(response){
            console.log(response.user_id);
            $('#form-editar-turma input[name="e_turma_id"]').val(response.turma_id);
            $('#form-editar-turma input[name="e_turma_nome"]').val(response.turma_nome);
            $('#form-editar-turma #e_turma_status option[value="'+response.turma_status+'"]').prop("selected", true);
            $('#form-editar-turma #e_curso_id option[value="'+response.curso_id+'"]').prop("selected", true);
            $('#form-editar-turma #e_professor_id option[value="'+response.user_id+'"]').prop("selected", true);
            $('#form-editar-turma #e_unidade_id option[value="'+response.unidade_id+'"]').prop("selected", true);
            $('#form-editar-turma input[name="e_data_inicio"]').val(response.data_abertura);
            $('#form-editar-turma input[name="e_data_encerramento"]').val(response.data_encerramento);
            $('#form-editar-turma input[name="e_horario"]').val(response.turma_horario);
            $('#form-editar-turma #e_turma_modulo option[value="'+response.modulo_id+'"]').prop("selected", true);
            $('#form-editar-turma #e_dia_semana option[value="'+response.dia_semana+'"]').prop("selected", true);
            $('#form-editar-turma input[name="e_hora_aula"]').val(response.duracao_aula);
        });
    }
    
    function editar(){
        var form = new FormData($("#form-editar-turma")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'turmas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0,"Falha ao editar turma!",2000);
            }
        });
        request.done(function(response){
            if(response == "2"){
                $("#lateral, #lateral .content").removeClass("active");
                $("#form-editar-turma")[0].reset();
                $("#form-editar-turma button").prop('disabled', false);
                criaAlerta(0, "Turma atualizada com sucesso!",5000);
                recarregar();
            }
        });
    }

    function deletar(turma_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'deletar-turmas/' + turma_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao deletar turma!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Turma deletada com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                recarregar();
            }else{
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Esta turma possui alunos atrelados a ela, remova seus alunos primeiro!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 5000);
            }
        });
    }

    function deletarAluno(aluno_id, turma_id){
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'aluno/' + aluno_id + '/' + turma_id,
            type: 'delete',
            error: function(){
                criaAlerta(0, "Falha ao remover aluno!",2000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#alerta .opcoes").addClass("hide");
                $("#alerta p").text("Aluno removido com sucesso!");
                $("#alerta .confirmar").prop('disabled', false);
                setTimeout(function(){
                    $("#alerta").removeClass("active");
                }, 2000);
                carregarAlunos($("#a_turma_id").val());
            }
        });
    }

    function adicionarAlunos(){
        var form = new FormData($("#form-adicionar-alunos")[0]);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'turmas',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao adicionar alunos!",5000);
            }
        });
        request.done(function(response){
            if(response == "3"){
                carregarAlunos(form.get("a_turma_id"));
                $("#form-adicionar-alunos button").prop('disabled', false);
                criaAlerta(0, "Aluno(s) adicionado(s) com sucesso!",5000);
            }else if(response == "4"){
                carregarAlunos(form.get("a_turma_id"));
                $("#form-adicionar-alunos button").prop('disabled', false);
                criaAlerta(0, "Opss parece que este(s) aluno(s) ja pertence a uma turma!",5000);
            }
        });
    }

    function salvarFrequencia(frequencia, proxAula){
        var form = new FormData($("#form-frequencia-turma")[0]);
        form.append("turma_aula_presencas", frequencia);
        form.append("prox_aula", proxAula);
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'turma-frequencia/',
            data: form,
            type: 'post',
            contentType: false,
            processData: false,
            error: function(){
                criaAlerta(0, "Falha ao salvar frequência!",5000);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#form-frequencia-turma button").prop('disabled', false);
                criaAlerta(0, "Frequência salva com sucesso!",5000);
                setTimeout(function(){
                    carregarTurma($("#v_turma_id").attr("data-id"));
                }, 2000);
            }
        });
    }

    function turmaMenus(){
        $(document).on("click", ".t-menu", function(){
            var menu = $(this).attr("data-menu");
            $(".t-container, .t-menu").removeClass("active");
            $('.t-container[data-menu="'+menu+'"]').addClass("active");
            $(this).addClass("active");
        });
    } turmaMenus();
    
</script>
@endsection
