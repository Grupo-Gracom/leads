function criaAlerta(tipo, text, tempo){
    $("#alerta p").empty();
    $("#alerta p").text(text);

    if(tipo == 0){
        $("#alerta .opcoes").addClass("hide");
        $("#alerta").addClass("active");
        setTimeout(function(){
            $("#alerta").removeClass("active");
        }, tempo)
    }else if(tipo == 1){
        $("#alerta .opcoes").removeClass("hide");
        $("#alerta").addClass("active");
    }
}