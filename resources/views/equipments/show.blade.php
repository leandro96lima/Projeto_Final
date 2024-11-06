<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/show.equipamento.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Detalhes do Equipamento') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="card">
            <ul><b>ID Equipamento:</b> {{ $equipment->id ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Tipo:</b> {{ $equipment->type ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Fabricante:</b> {{ $equipment->manufacturer ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Modelo:</b> {{ $equipment->model ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Serial Number:</b> {{ $equipment->serial_number ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Sala:</b> {{ $equipment->room ?? 'N/A' }}</ul>
        </div>


            <section class="cardinterior">
                <div class="botaospace">
                    <a href="{{ route('equipments.index') }}">
                        <input class="botao" type="button" value="Voltar">
                    </a>
                </div>
            </section>

    </div>
</section>
</body>

</html>
