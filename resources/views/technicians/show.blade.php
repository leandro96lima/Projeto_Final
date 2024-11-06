<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/tecnicopage.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix - Perfil do Técnico</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Perfil do Técnico') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="card">
            <ul><b>ID Técnico: </b> {{ $technician->id }}</ul>
        </div>
        <div class="card">
            <ul><b>Nome do Técnico: </b> {{ $technician->user->name }}</ul>
        </div>
        <div class="card">
            <ul><b>Especialidade: </b> {{ $technician->specialty }}</ul>
        </div>

        <section class="cardinterior">
            <div class="botaospace">
            <a href="{{ route('technicians.edit', $technician->id) }}">
                <button class="botao2" type="button">Editar</button>
            </a>
            </div>

            <div class="botaospace">
                <a href="{{ route('technicians.index') }}">
                    <input class="botao" type="button" value="Voltar">
                </a>
            </div>
        </section>
    </div>
</section>
</body>
</html>
