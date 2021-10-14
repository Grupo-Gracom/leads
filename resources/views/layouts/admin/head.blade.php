<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- title -->
    <title>@yield('titulo')</title>
    <!-- metas -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="https://grupogracom.com.br/images/icon.png">
    <!-- css -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/b-1.6.2/datatables.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/admin/css/admin.css')}}">
    <!-- scripts -->
    <script src="{{ asset('assets/admin/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/admin/js/mask.js') }}"></script>
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/chart.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.21/b-1.6.2/datatables.min.js"></script>
    
</head>

<body>
    @include('layouts.admin.nav')
    @yield('conteudo')
    <!-- <div id="raiz"></div>
    <script>
        $("#raiz").load("menus", function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                var menus = JSON.parse($('input[name="list-menus"]').val());
                menus.forEach( m => {
                    $('nav li[data-menu-id="'+m+'"]').css({"display":"block"});
                });
            }
            if(statusTxt == "error"){
                criaAlerta(0, "Erro: " + xhr.status + ": " + xhr.statusText, 2000);
            }
        });
        $(document).on("click", "nav .sub-menu", function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active");
            }else{
                $("nav .sub-menu").removeClass("active");
                $(this).addClass("active");
            }
        });
    </script> -->