@extends('layouts.admin.head')
@section('titulo','Dashboard')
@section('conteudo')
<main>
<div class="leads">
        <h3>Leads
            <form id="Periodo">
                <input type="date" name="data_inicio" placeholder="Data Inicial">
                <input type="date" name="data_fim" placeholder="Data Final">
                <button type="submit" class="suave click"><span class="mini-title upper">Pesquisar</span></button>
            </form>
        </h3>
        <ul>
            <a href="#" id="gracomInfo">
            <li class="suave ativo" id="logoGracom">
                <figure>
                    <img src="https://fpeduc.com/img/logo-gracom.png" alt="">
                </figure>
                <h6>Gracom</h6>
                <h2 id="quantidade">-</h2>
            </li>
            </a>
            <a href="#" id="imugiInfo">
            <li class="suave" id="logoImugi">
                <figure>
                    <img src="https://fpeduc.com/img/logo-imugi.png" alt="">
                </figure>
                <h6>Imugi</h6>
                <h2 id="quantidadeImugi">-</h2>
            </li>
            </a>
            <li class="suave">
                <figure>
                    <img src="https://tiamate.com.br/assets/demos/cafe/images/logo1.png">
                </figure>
                <h6>Tiamate</h6>
                <h2>-</h2>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="leads" id="PanelGracom">
        <h3>Detalhes Gracom</h3>
        <ul>
            <li class="suave">
                <h6>Total de Leads</h6>
                <h2 id="total">-</h2>
            </li>
            <li class="suave">
                <h6 class="truncate">Leads Mês Atual</h6>
                <h2 id="mesAtual">-</h2>
            </li>
            <li class="suave">
                <h6>Leads Atendidos</h6>
                <h2>-</h2>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="leads" id="PanelImugi">
        <h3>Detalhes Imugi</h3>
        <ul>
            <li class="suave">
                <h6>Total de Leads</h6>
                <h2 id="totalImugi">-</h2>
            </li>
            <li class="suave">
                <h6 class="truncate">Leads Mês Atual</h6>
                <h2 id="mesAtualImugi">-</h2>
            </li>
            <li class="suave">
                <h6>Leads Atendidos</h6>
                <h2>-</h2>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="estados" id="estadoGracom">
        <h3>Leads Por Estado: {{date("M")}}</h3>
        <ul id="estadosGracom">
        </ul>
    </div>
    <div class="clear"></div>
    <div class="estados" id="estadoImugi">
        <h3>Leads Por Estado: {{date("M")}}</h3>
        <ul id="estadosImugi">
        </ul>
    </div>
    <canvas id="graficoVolume"></canvas>
</div>
</main>
<div id="lateral" class="suave">
    <div class="overlay suave"></div>
    <div id="criar" class="content suave">
        <h4>Leads por Unidade <i class="material-icons click suave fechar">close</i></h4>
        <hr>
        <ul id="resultadoGracom">
        </ul>
    </div>
</div>

<div id="lateralImugi" class="suave">
    <div class="overlay suave"></div>
    <div id="criarImugi" class="content suave">
        <h4>Leads por Unidade <i class="material-icons click suave fechar">close</i></h4>
        <hr>
        <ul id="resultadoImugi">
        </ul>
    </div>
</div>
<script>
         var largura = $(window).width();
            var tipo = "";
            if(largura > 380){
                tipo = "x";
            }else{
                tipo = "y";
            }
            var canvas = document.getElementById('graficoVolume').getContext('2d');
            var grafico = new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($volumeLabels); ?>,
                        datasets: [{
                            label: 'Venda iniciada',
                            data: <?php echo json_encode($volumeLabels); ?>,
                            backgroundColor: 'rgba(255, 255, 255, .1)',
                            borderColor: 'rgba(255, 255, 255, 1)',
                            borderWidth: '2'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    },
                    indexAxis: "x",
                }
            });
            

            
    $(document).ready(function(){
        var qtd = document.getElementById("quantidade").value;
        var link = "https://gracomonline.com.br/quantidade";
  $.ajax({
      url: link,
      type: 'GET',
      dataType: 'json',

    })
    .done(function(data) {
     var quant = JSON.parse(data);
      document.getElementById("quantidade").innerHTML = quant;
      document.getElementById("total").innerHTML = quant;
      document.getElementById("mesAtual").innerHTML = quant;
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
});

$(document).ready(function(){
    $("#PanelImugi").hide();
    $("#estadoImugi").hide();
        var qtd = document.getElementById("quantidade").value;
        var link = "https://site.imugi.com.br/quantidade";
  $.ajax({
      url: link,
      type: 'GET',
      dataType: 'json',

    })
    .done(function(data) {
     var quantImugi = JSON.parse(data);
      document.getElementById("quantidadeImugi").innerHTML = quantImugi;
        document.getElementById("totalImugi").innerHTML = quantImugi;
        document.getElementById("mesAtualImugi").innerHTML = quantImugi;
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
});
    
    function consultar(){
        request = $.ajax({
            url: 'https://gracomonline.com.br/leads-estado',
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
            $.each(data, function (key, value) {
                $("#estadosGracom").append('<li class="suave click unidade-gracom" data-unidade='+value.id_estados+'><h6 class="truncate" >'+value.estado_nome+'</h6><h2>'+value.quantidade.length+'</h2></li>');
            });

            $(".unidade-gracom").click(function(){
                $("#resultadoGracom").html('');
                var und = $(this).attr("data-unidade")
                consultarUnidadeGracom(und);
                $("#lateral, #criar").addClass("active");
            });
            
    $("#lateral .fechar").click(function(){
        $("#resultadoGracom").html('');
        $("#lateral, #lateral .content").removeClass("active");
    });

            },
            complete: function(xhr, textStatus) {} 
        });
    }consultar();
    function consultarImugi(){
        request = $.ajax({
            url: 'https://site.imugi.com.br/leads-estado',
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
            $.each(data, function (key, value) {
                $("#estadosImugi").append('<li class="suave click unidade-imugi" data-unidade='+value.id_estados+'><h6 class="truncate">'+value.estado_nome+'</h6><h2>'+value.quantidade.length+'</h2></li>');
            });

            $(".unidade-imugi").click(function(){
                $("#resultadoImugi").html('');
                var und = $(this).attr("data-unidade")
               console.log(und);
                consultarUnidadeImugi(und);
                $("#lateralImugi, #criarImugi").addClass("active");
            });

            $("#lateralImugi .fechar").click(function(){
        $("#resultadoImugi").html('');
        $("#lateralImugi, #lateralImugi .content").removeClass("active");
    });

            },
            complete: function(xhr, textStatus) {} 
        });
    }consultarImugi();

    function consultarUnidadeGracom(unidade){
        request = $.ajax({
            url: 'https://gracomonline.com.br/leads-unidades/'+unidade,
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
            $.each(data, function (key, value) {
                $("#resultadoGracom").append('<li class="suave"><h6 class="truncate">'+value.unidade_nome+'</h6><h2>'+value.alunos.length+'</h2></li><hr class="borda-unidade">');
            });

            },
            complete: function(xhr, textStatus) {} 
        });
    }

    function consultarUnidadeImugi(unidade){
        request = $.ajax({
            url: 'https://site.imugi.com.br/leads-unidades/'+unidade,
            type: 'get',
            error: function(){
                alerta("Ocorreu um erro, atualize a página");
            },
            success: function(data, textStatus, xhr){
            $.each(data, function (key, value) {
                $("#resultadoImugi").append('<li class="suave"><h6 class="truncate">'+value.unidade_nome+'</h6><h2>'+value.alunos.length+'</h2></li><hr class="borda-unidade">');
            });

            },
            complete: function(xhr, textStatus) {} 
        });
    }


    $( "#imugiInfo" ).click(function() {
        $("#logoImugi").addClass("ativo");
        $("#logoGracom").removeClass("ativo");
        $("#PanelImugi").show();
        $("#estadoImugi").show();
        $("#PanelGracom").hide();
        $("#estadoGracom").hide();
});
$( "#gracomInfo" ).click(function() {
        $("#logoGracom").addClass("ativo");
        $("#logoImugi").removeClass("ativo");
        
        $("#PanelGracom").show();
        $("#estadoGracom").show();
        $("#PanelImugi").hide();
        $("#estadoImugi").hide();
});

$("#Periodo").submit(function(e){
                    e.preventDefault();
                    $("#Periodo button").prop("disabled", true);
                    $("#Periodo button span").text("Carregando");
                    carregarPeriodo(grafico);
                });


                function carregarPeriodo(grafico){
                    var form = new FormData($("#Periodo")[0]);
                    request = $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: 'https://gracomonline.com.br/consultar-periodo',
                        data: form,
                        type: 'post',
                        contentType: false,
                        processData: false,
                        error: function(){
                            alerta("Falha ao carregar dados");
                            $("#Periodo button").prop("disabled", false);
                            $("#Periodo button span").text("Pesquisar");
                        }
                    });
                    request.done(function(response){
                        
                        $("#Periodo button").prop('disabled', false);
                        $("#Periodo button span").text("Pesquisar");
                        
                        // $(".total-iniciado").text(response.totalIniciado);
                        // $(".total-concluido").text(response.totalConcluido);
                        
                
                        var datasets = [{
                                            label: 'Venda iniciada',
                                            data: response.volumeIniciado,
                                            backgroundColor: 'rgba(255, 255, 255, .1)',
                                            borderColor: 'rgba(255, 255, 255, 1)',
                                            borderWidth: '2'
                                        }];
                        grafico.data.datasets = datasets;
                        grafico.data.labels = response.volumeLabels;
                        grafico.update('active');
                        
                    });
                }

   
</script>
@endsection

