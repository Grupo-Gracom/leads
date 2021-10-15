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

