<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/relatóriodeavaria.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Detalhes da Avaria') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="card">
            <ul><b>ID ticket da Avaria:</b> {{ $malfunction->ticket->id ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Equipamento Avariado:</b> {{ $malfunction->equipment->type ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Descrição da Avaria:</b> {{ $malfunction->ticket->description ?? 'N/A' }}</ul>
        </div>
        <div class="card">
            <ul><b>Status Atual:</b> {{ $malfunction->ticket->status ?? 'N/A' }}</ul>
        </div>

        <div class="card">
            <ul><b>Urgência:</b> {{ $malfunction->ticket->urgent ? 'Sim' : 'Não' }}</ul>
        </div>

        <div class="card">
            <ul><b>Tempo de Resolução:</b>
                <span class="resolutionTime">
                    @if($malfunction->ticket->resolution_time)
                        {{ (int) optional($malfunction->ticket)->resolution_time }} minuto(s)
                    @else
                        Em espera para terminar
                    @endif
                </span>
            </ul>
        </div>

        <div class="card">
            <ul><b>Custo:</b> {{ $malfunction->cost ?? 'N/A' }}</ul>
        </div>

        <div class="card">
            <section class="cardinterior">
                <div>
                    <ul><b>Diagnóstico:</b></ul>
                    <br>
                    {{ $malfunction->diagnosis ?? 'N/A' }}
                </div>
            </section>
        </div>

        <div class="card">
            <section class="cardinterior">
                <div>
                    <ul><b>Solução da Avaria:</b></ul>
                    <br>
                    {{ $malfunction->solution ?? 'N/A' }}
                </div>
            </section>
        </div>
        <div class="botaospace">
            <button type="button" class="botao2" onclick="window.location.href='{{ route('malfunctions.edit', [$malfunction->id]) }}'">Editar Avaria</button>
        </div>
        <div class="botaospace">
            <button type="button" class="botao" onclick="window.location.href='{{ route('malfunctions.index', [$malfunction->id]) }}'">Voltar à Lista</button>
        </div>
    </div>
</section>

</body>
</html>
