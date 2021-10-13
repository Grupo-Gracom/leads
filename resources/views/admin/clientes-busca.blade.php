
@if(sizeOf($clientes) == 0)
    <li>
        <div><h6>Nenhum aluno encontrado!</h6></div>
    </li>
@else
    @foreach($clientes as $cliente)
    <li data-item="{{ $cliente->id }}">
        <div>
            <h6>
                <p class="checkbox" style="margin-top: 0;margin-bottom: 0;">
                    <input type="checkbox" name="alunos[]" value="{{ $cliente->id }}">
                </p>    
            </h6>
        </div>
        <div data-item="{{ $cliente->cliente_id }}"><h6>{{ $cliente->id }}</h6></div>
        <div><h6>{{ $cliente->name }}</h6></div>
        <div>
            <h6>
                @if($cliente->matricula == "")
                    -
                @else
                    {{ $cliente->matricula }}
                @endif
            </h6>
        </div>
    </li>
    @endforeach
@endif