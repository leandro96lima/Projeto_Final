<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app') <!-- Altere 'layouts.app' para o seu layout específico -->

@section('content')
    <div class="container">
        <h1>Página Não Encontrada</h1>
        <p>Desculpe, a página que você está procurando não existe.</p>
        <a href="{{ route('home') }}">Voltar para a página inicial</a>
    </div>
@endsection
