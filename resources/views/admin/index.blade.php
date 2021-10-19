@extends('layouts.admin.head')
@section('titulo','Dashboard')
@section('conteudo')
<main>
<div class="leads">
        <h3>Leads</h3>
        <ul>
            <a href="admin/gracom">
            <li class="suave">
                <figure>
                    <img src="https://fpeduc.com/img/logo-gracom.png" alt="">
                </figure>
                <h6>Gracom</h6>
                <h2 id="quantidade">-</h2>
            </li>
            </a>
            <li class="suave">
                <figure>
                    <img src="https://fpeduc.com/img/logo-imugi.png" alt="">
                </figure>
                <h6>Imugi</h6>
                <h2>-</h2>
            </li>
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
    <div class="leads">
        <h3>Detalhes</h3>
        <ul>
            <li class="suave">
                <h6>Total de Leads</h6>
                <h2 id="total">-</h2>
            </li>
            <li class="suave">
                <h6 class="truncate">Leads Mês Atual</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Leads Atendidos</h6>
                <h2>-</h2>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="estados">
        <h3>Leads Por Estado: {{date("M")}}</h3>
        <ul>
            <li class="suave">
                <h6>Acre</h6>
                <h2 id="total">-</h2>
            </li>
            <li class="suave">
                <h6 class="truncate">Alagoas</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Amapá</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Amazonas</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Bahia</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Ceará</h6>
                <h2>-</h2>
            </li>
        </ul>
        <ul>
            
            <li class="suave">
                <h6>Espírito Santo</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Goiás</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Maranhão</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Mato Grosso</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Minas Gerais</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Pará</h6>
                <h2>-</h2>
            </li>
        </ul>
        <ul>
            <li class="suave">
                <h6>Paraíba</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Paraná</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Pernambuco</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Piauí</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Rio de Janeiro</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Rio Grande do Norte</h6>
                <h2>-</h2>
            </li>
        </ul>
        <ul>
            <li class="suave">
                <h6>Rio de Janeiro</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Rio Grande do Norte</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Rio Grande do Sul</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Rondônia</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Roraima</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Santa Catarina</h6>
                <h2>-</h2>
            </li>
        </ul>
        <ul>
            <li class="suave">
                <h6>São Paulo</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Sergipe</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Tocantins</h6>
                <h2>-</h2>
            </li>
            <li class="suave">
                <h6>Distrito Federal</h6>
                <h2>-</h2>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
</main>
<script>
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
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
});
</script>
@endsection

