
@if(sizeOf($clientes) == 0)
    <li>
        <div><h6>Nenhum aluno encontrado!</h6></div>
    </li>
@else

    @foreach($clientes as $cliente)
    <li>
        <div><h6>{{ $cliente->turma_cliente_id }}</h6></div>
        <div><h6>{{ $cliente->cliente_id }}</h6></div>
        <div><h6>{{ $cliente->alunos->name }}</h6></div>
        <div>
            <i class="material-icons click deletar-aluno" data-id="{{ $cliente->turma_cliente_id }}">delete</i>
        </div>
    </li>
    @endforeach
@endif