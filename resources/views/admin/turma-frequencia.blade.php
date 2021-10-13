
@if(sizeOf($clientes) == 0)
    <li>
        <div><h6>Nenhum aluno encontrado!</h6></div>
    </li>
@else
    @if($turma->modulo_id == '')
        <?php
            $modulo = $turma->curso->uas[0]->modulo[0];
            $aula = $turma->curso->uas[0]->modulo[0]->aula[0];
        ?>
    @else
        <?php
            $modulo = $turma->modulo;
            $aula = $turma->aula;
        ?>
    @endif
    <form method="post">
        @foreach($clientes as $cliente)
        <li>
            <div><h6>{{ $cliente->cliente_id }}</h6></div>
            <div><h6>{{ $cliente->cliente->cliente_nome }}</h6></div>
            <div>
                <div class="checkbox">
                    <input type="checkbox" name="{{ $aula->aula_id }}">
                </div>
            </div>
        </li>
        @endforeach
    </form>
@endif