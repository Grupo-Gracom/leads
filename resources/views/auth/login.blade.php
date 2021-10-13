@extends('layouts.headLogin')
@section('titulo','Grupo Gracom Leads')
@section('conteudo')
<section id="login">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <figure>
            <img src="{{ asset('assets/admin/images/logogrupo.png') }}" alt="Grupo Gracom">
        </figure>
        <h6 class="titulo">Acesse seus leads</h6>
        <div class="input-field">
            <i class="material-icons">account_circle</i>
            <input id="email" type="email" class="suave" name="email" required autofocus placeholder="Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="input-field">
            <i class="material-icons">lock</i>
            <input id="password" type="password" class="suave" name="password" required placeholder="Senha">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="suave click">{{ __('Login') }}</button>
    </form>
</section>
@endsection