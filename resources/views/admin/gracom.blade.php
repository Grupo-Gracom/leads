@extends('layouts.admin.head')
@section('titulo','Leads Gracom')
@section('conteudo')
<main>
    <h3>Leads Gracom
    <input type="hidden" name="unidade" data-estado="{{ $unidade}}">
    </h3>
    <div id="leads-gracom" class="box">
        <table id="tabela" class="stripe">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Nome</td>
                    <td>Email</td>
                    <td>Telefone</td>
                    <td>unidade</td>
                    <td>Como Conheceu</td>
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
                url: 'https://gracomonline.com.br/api-leads'+ unidade,
                dataSrc: ''
            },
            columns: [
                {data: 'id', width: "60px", className: 'dt-body-center dt-head-center'},
                {data: 'nome',width: "120px"},
                {data: 'email', width: "100px"},
                {data: 'telefone', width: "100px"},
                {data: 'unidade.unidade_nome', width: "120px"},
                {data: null,width: "160px", className: 'dt-body-center dt-head-center',
                    render: function ( data, type, row ) {
                        switch(row.como_conheceu){
                            case "1":
                            $conheceu = "<span class='btn site'>Site</span>";
                                break;
                            case "2":
                            $conheceu = "<span class='btn midias'>Midias Digitais</span>";
                                break;
                            case "3":
                            $conheceu = "<span class='btn redes'>Redes Sociais</span>";
                                break;
                            case "4":
                            $conheceu = "<span class='btn outros'>Outros</span>";
                                break;
                            
                            default:
                            $conheceu = "<span class='btn indefinido'> Indefinido</span>";
                        }
                        return $conheceu;
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