@include('layouts.admin.head')
@section('titulo','Alunos | Portal do Aluno')

<main>
    <!-- <div class="box filtro">
        <h3>
            Busca:
            <span>
                <input type="text" name="busca" id="busca" class="filtro-notas" placeholder="ex: nome ou matricula">
            </span>
            <span><select id="modulo" class="filtro-notas">
                    <option value="">Todos os Modulos?</option>
                    <option>Illustrator CC</option>
                    <option>Photoshop CC</option>
                    <option>Lightroom CC</option>
                    <option>Indesign CC</option>
                    <option>Muse CC</option>
                    <option>Dreamweaver CC</option>
                    <option>Animate CC</option>
                    <option>Premiere CC</option>
                    <option>After Effects CC</option>
                    <option>3DS Max Modelagem</option>
                    <option>3DS Max Animação</option>
                    <option>3DS Max Render</option>

                </select> </span>
            <span><select id="avaliacao" class="filtro-notas">
                    <option value="">Todas as Avaliação?</option>
                    <option>TEÓRICA</option>
                    <option>- PROVA PRÁTICA</option>
                    <option>TRABALHOS</option>
                </select> </span>
        </h3>
    </div> -->
    <div id="alunos" class="box margin-topo">
        <h3>
            Alunos
        </h3>
        <table id="tAlunos" style="padding-top: 16px;" class="stripe">
            <thead>
                <tr>
                    <td class="mini-title upper">#</td>
                    <td class="mini-title upper">Matricula</td>
                    <td class="mini-title upper">Nome</td>
                    <td class="mini-title upper">Nota</td>
                    <td class="mini-title upper">Modulo</td>
                    <td class="mini-title upper">Qual Avaliação?</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</main>
<script>
$('#busca').on('keyup', function() {
    table.search(this.value).draw();
});

$('#modulo').on('change', function() {
    table.column(4).search(this.value).draw();
});

$('#avaliacao').on('change', function() {
    table.column(5).search(this.value).draw();
});
var table;

function carregar() {
    table = $('#tAlunos').DataTable({
        ajax: {
            url: 'alunos-lista',
            dataSrc: ''
        },
        columns: [{
                data: 'id_notas_fp',
                width: "60px",
                className: 'dt-body-center dt-head-center'
            },
            {
                data: 'matricula'
            },
            {
                data: 'nome_aluno'
            },
            {
                data: 'nota',
                "defaultContent": "Indefinido"
            },
            {
                data: 'modulo',
                "defaultContent": "Indefinido"
            },
            {
                data: 'avaliacao',
                width: "300px",
                "defaultContent": "Indefinido"
            },
        ],
        columnDefs: [{
            targets: -1,
            width: "80px",
            className: 'dt-body-center dt-head-center',
            data: null
        }],
        language: {
            processing: "Carregando",
            search: "Pesquisar",
            lengthMenu: "Mostrando _MENU_ registros",
            info: "De _START_ à _END_ de _TOTAL_ registros",
            paginate: {
                first: "Primeiro",
                previous: "Anterior",
                next: "Próximo",
                last: "Último"
            },
            emptyTable: "Nenhum registro cadastrado!",
            zeroRecords: "Nenhum registro encontrado!",
            loadingRecords: "Carregando...",
            infoEmpty: "Nenhum registro encontrado",
            infoFiltered: "(filtrado de _MAX_ cadastros)",

        }
    });
}
carregar();
</script>