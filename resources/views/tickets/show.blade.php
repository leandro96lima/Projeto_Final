<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/showtickets.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Detalhes do Ticket') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        @php
            $ticketDetails = [
                __('Data de abertura:') => $ticket->open_date ?: 'N/A',
                __('Equipamento Avariado:') => optional($ticket->malfunction->equipment)->type ?: 'N/A',
                __('Serial Number:') => optional($ticket->malfunction->equipment)->serial_number ?: 'N/A',
                __('Sala:') => optional($ticket->malfunction->equipment)->room ?: 'N/A',
                __('Tempo de espera:') => $ticket->malfunction ? ($ticket->wait_time !== null ? $ticket->wait_time . ' minuto(s)' : 'Em espera para iniciar') : 'Em espera para iniciar',
                __('Status:') => $ticket->status ?: 'N/A',
                __('Avaria:') => $ticket->title ?: 'N/A',
                __('Descrição:') => $ticket->description ?: 'N/A',
                __('Diagnóstico:') => $ticket->malfunction->diagnosis ?: 'N/A',
                __('Solução de Avaria:') => $ticket->malfunction->solution ?: 'N/A',
                __('Custo:') => $ticket->malfunction->cost ?: 'N/A',
            ];
        @endphp

        @foreach ($ticketDetails as $label => $value)
            <div class="card">
                <ul><b>{{ $label }}</b> {{ $value }}</ul>
            </div>
        @endforeach

        <div class="botaospace">
            <a href="{{ route('dashboard') }}">
                <input class="botao" type="button" value="Voltar à Lista">
            </a>
        </div>
    </div>
</section>
</body>
</html>
