@extends('layouts/admin/header/header')
@section('titulo','Notas | Portal do Aluno')
@section('conteudo')
<main>
    <div class="box filtro">
        <h3>
    Turma: <span id="table-filter"><select id="turma" class="filtro-notas">
<option value="">Todos</option>
@foreach($turmas as $turma)
    <option>{{$turma->turma_nome}}</option>
                   @endforeach
</select> </span>
    Modulo: <span id="table-filter"> <select id="modulo" class="filtro-notas">
<option value="">Todos</option>
@foreach($modulos as $modulo)
                    <option >{{$modulo->modulo_nome}}</option>
@endforeach
</select> </span>
<div class="click suave criar"><i class="material-icons">add_circle</i><span class="mini-title">Inserir Nota<span></div>
</h3>
    </div>
    <div class="box margin-topo">
       <h3>Notas </h3>
       <table width="100%" id="tNota"  style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Aluno</td>
                    <td class="mini-title upper select-filter">Modulo</td>
                    <td class="mini-title upper select-filter">Turma</td>
                    <td class="mini-title upper">Prova Teorica</td>
                    <td class="mini-title upper">Prova Pratica</td>
                    <td class="mini-title upper">Trabalhos</td>
                    <td class="mini-title upper">Média</td>
                    <td class="mini-title upper">Ações</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper "></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                    <td class="mini-title upper"></td>
                </tr>
        </tfoot>
        </table>

    </div>
</main>
<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="visualizar" class="content suave" style="padding: 0;">
        <h4 class="barlow" style="position: absolute;right: 16px;top: 16px;"><i class="material-icons click suave fechar">close</i></h4>
    </div>
    <div id="criar" class="content suave">
        <h4 class="barlow">Dados do Aluno <i class="material-icons click suave fechar">close</i></h4>
        <form id="form-criar-nota" action="" method="post">
            <label for="turmaNota">Qual Turma?</label>
            <select name="turmaNota" id="turmaNota">
            <option value='0'>-- Selecione a Turma --</option>
                @foreach($turmas as $turma)
                <option value="{{$turma->turma_id}}">{{$turma->turma_nome }}</option>
                 @endforeach
            </select>
            <div class="clear"></div>
            <label for="IDaluno">Qual Aluno?</label>
            <select id='IDaluno' name='IDaluno'>
       <option value='0'>-- Selecione Aluno --</option>
    </select>
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="notaTeorica">Nota Téorica</label>
                <input type="text" name="notaTeorica" id="notaTeorica">
            </div>
            <div class="metade direita">
                <label for="notaPratica">Nota Prática</label>
                <input type="text" name="notaPratica" id="notaPratica">
            </div>
            <div class="clear"></div>
            <div class="metade esquerda">
                <label for="notaTrabalho">Nota Trabalhos</label>
                <input type="text" name="notaTrabalho" id="notaTrabalho">
            </div>
            <div class="metade direita">
                <label for="moduloNota">Qual Modulo?</label>
                <select id="moduloNota" name="moduloNota">
                    @foreach($modulos as $modulo)
                        <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_nome}}</option>
                    @endforeach
                </select>
            </div>
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

    $('select#turmaNota').on('change', function(){
        
    });

    $("#form-criar-nota").submit(function(e){
        e.preventDefault();
        $("#form-criar-nota button").prop('disabled', true);
       criar();
    });

    function criar(){
       var aluno = $("#IDaluno").val();
       var n_teorica = $("#notaTeorica").val();
       var nota_1 = n_teorica.replace(",", ".");
       var n_pratica = $("#notaPratica").val();
       var nota_2 = n_pratica.replace(",", ".");
    var n_trabalho = $("#notaTrabalho").val();
    var nota_3 = n_trabalho.replace(",", ".");
       var modulo = $("#moduloNota").val();
       var turma = $("#turmaNota").val();
       
       
       var notas = {"teorica":nota_1,"pratica":nota_2,"trabalho":nota_3,"id":aluno,"modulo":modulo,"turma":turma};
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'nota-fp',
            data: notas,
            type: 'post',
            error: function(){
                criaAlerta(0, "Falha ao lançar Nota!",5000);
                $("#form-criar-nota")[0].reset();
                $("#form-criar-nota button").prop('disabled', false);
            }
        });
        request.done(function(response){
            if(response == "1"){
                $("#lateral, #lateral .content").removeClass("active");
                criaAlerta(0, "Nota Lançada com sucesso!",5000);
                $("#form-criar-nota")[0].reset();
                recarregar();

            }else{
                $("#lateral, #lateral .content").removeClass("active");
                criaAlerta(0, "Opss, parece que esse aluno ja possue uma nota lançada!",5000);
                $("#form-criar-nota")[0].reset();
            }
        });
    }

    function recarregar(){
        table.ajax.reload();   
    }
   
    var table;
    

    function carregar(turma,modulo){
        
     table = $('#tNota').DataTable({

       dom: 'lr<"table-filter-container">tip',
        initComplete: function(settings){
          var api = new $.fn.dataTable.Api( settings );
          
          $('#table-filter select#turma').on('change', function(){
             table.column(3).search(this.value).draw();   
          });

          $('#table-filter select#modulo').on('change', function(){
             table.column(2).search(this.value).draw();   
          });
          
        },
            ajax: {
                url: 'lista-notas/'+turma+'/'+modulo,
                dataSrc: '',
                'processing': true,
            },
            columns: [
                {data: 'alunos.id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'alunos.name', width: "320px", className: 'dt-body-center dt-head-center'},
                {data: 'modulo.modulo_nome', width: "220px", className: 'dt-body-center dt-head-center',  "defaultContent": "Processando..."},
                {data: 'turma.turma_nome', width: "220px", className: 'dt-body-center dt-head-center',"defaultContent": "Indefinido..."},
                {data: null, width: "100px", "defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                       
                        input = '<input type="text" name="teorica" class="btn-nota" readonly id="teorica'+row.alunos.id+'" value="'+row.resultado_teorica+'">';
                        return input;
                    }
                },
                {data: null, width: "100px", "defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        
                        input = '<input type="text" name="pratica" class="btn-nota" id="pratica'+row.alunos.id+'" value="'+row.resultado_pratica+'">';
                        return input;
                    }
                },
                {data: null, width: "100px", "defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        input = '<input type="text" name="trabalho" class="btn-nota" id="trabalho'+row.alunos.id+'" value="'+row.resultado_trabalho+'">';
                        return input;
                    }
                },
                {data: null, width: "100px", "defaultContent": "Indefinido...", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        var media = (row.resultado_teorica + row.resultado_pratica+ row.resultado_trabalho)/3;
                        var mediaFinal = parseFloat(media.toFixed(1));
                       
                        input ='<input type="text" class="btn-nota" value="'+mediaFinal+'" readonly>';
                        return input;
                    }
                },
                {data: null, width: "100px", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        input ='<button type="submit" class="lancar" onclick="update('+row.alunos.id+','+row.modulo_id+','+row.turma_id+')"><i class="material-icons">check</i></button>';
                        return input;
                    }
                }
            ],
            columnDefs: [
                {
                    targets: -1,
                    width: "80px",
                    className: 'dt-body-center dt-head-center',
                    data: null,
                    "searchable": false
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

    

    function update(id_aluno,modulo,turma){
        
        var notateorica =  $('#teorica'+id_aluno).val();
        var nota = notateorica.replace(",", ".");
        
        var notapratica =  $('#pratica'+id_aluno).val();
        var nota2 = notapratica.replace(",", ".");
        
        var notatrabalho = $('#trabalho'+id_aluno).val();
        var nota3 = notatrabalho.replace(",", ".");

        var notas = {"teorica":nota,"pratica":nota2,"trabalho":nota3,"id":id_aluno,"modulo":modulo,"turma":turma};
        
        request = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'add-notas',
            type: 'POST',
            data: notas,
            error: function(){
                criaAlerta(0,"Falha ao editar Nota!",1600);
            }
        });
        request.done(function(response){
            if(response == "1"){
                criaAlerta(0, "Nota Inserida com sucesso!",1600);
                recarregar();
            }else{
                criaAlerta(0, "Nota Atualizada com sucesso!",1600);
                recarregar();
            }
        });
    }

    $(document).ready(function(){

// Department Change
$('#turmaNota').change(function(){

   // Department id
   var id = $(this).val();

   // Empty the dropdown
   $('#IDaluno').find('option').not(':first').remove();

   // AJAX request 
   $.ajax({
     url: 'alunos-turma/'+id,
     type: 'get',
     dataType: 'json',
     success: function(response){

       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
       }

       if(len > 0){
         // Read data and create <option >
         for(var i=0; i<len; i++){

           var id = response['data'][i].alunos.id;
           var name = response['data'][i].alunos.name;

           var option = "<option value='"+id+"'>"+name+"</option>"; 

           $("#IDaluno").append(option); 
         }
       }

     }
  });
});

});

   
</script>
@endsection
