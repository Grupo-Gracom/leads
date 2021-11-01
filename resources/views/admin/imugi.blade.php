@extends('layouts.admin.head')
@section('titulo','Leads Imugi')
@section('conteudo')
<main>
    <h3>Leads Imugi
    <input type="hidden" name="unidade" data-estado="{{ $unidade}}">
    </h3>
    <div id="leads-imugi" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td>unidade</td>
                    <td>status</td>
                    <td>Data Cadastro</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<script>
    var table;
    var unidade =  $('input[name="unidade"]').attr("data-estado");
    function carregar(){
        table = $('#tabela').DataTable({
            
            ajax: {
                url: 'https://site.imugi.com.br/api-leads/'+ unidade,
                dataSrc: ''
            },
            columns: [
                {data: 'id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'nome'},
                {data: 'telefone'},
                {data: 'unidade.unidade_nome'},
                {data: null, className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        if(row.status == 1){
                          return "<span class='btn nao-atendido'> não atendido</span>";
                      }else{
                          return "<span class='btn atendido'> atendido</span>";
                      }
                    }
                },
                {data: null, className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        var date = new Date(row.data_cadastro);
                        return date.toLocaleDateString();
                    }
                },
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
     
    } carregar();

    function recarregar(){
        table.ajax.reload();
    }    

</script>
@endsection