@foreach($cargos as $cargo)
    @if($cargo->cargo_id == Auth::user()->cargo_id)
        <input type="hidden" name="list-menus" value="{{ $cargo->cargo_menus }}">
    @endif
@endforeach