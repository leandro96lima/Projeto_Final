<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/editarAvaria.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Editar Avaria') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <form action="{{ route('malfunctions.update', $malfunction->id) }}" method="post">
            @csrf
            @method('PATCH')

            <input type="hidden" name="action" value="{{ $action }}">

        <div class="card">
            <ul><b>ID ticket da Avaria:</b>
                {{ $malfunction->ticket->id }}
            </ul>
        </div>

        @if($action === 'fechar' || $action === 'abrir' || $action === '')
        <div class="card">
            <ul><b>Equipamento Avariado:</b>
                <br>
                <input type="text" name="Equipamento Avariado" @if($action === 'fechar' || $action === 'abrir') readonly @endif value="{{ $malfunction->equipment->type }}" required>
            </ul>
        </div>
        @endif

        @if($action === 'fechar' || $action === 'abrir' || $action === '')
        <div class="card">
            <ul><b>Descrição da Avaria:</b>
                <br><br>
                <textarea name="Descrição" id="areadescricao" @if($action === 'fechar' || $action === 'abrir') readonly @endif>{{ $malfunction->ticket->description }}</textarea>
            </ul>
        </div>
        @endif

            @if($action === 'abrir')
            <div class="card">
                <ul><b>Status Atual:</b></ul>
                <br>
                <select id="funcaodrop" class="dropdown2" name="status" required>
                    <option value="in_progress" {{ old('status', $malfunction->ticket->status) == 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                </select>
            </div>
            @endif

            @if($action === 'fechar')
                <div class="card">
                    <ul><b>Status Atual:</b></ul>
                    <br>
                    <select id="funcaodrop" class="dropdown2" name="status" required>
                        <option value="closed" {{ old('status', $malfunction->ticket->status) == 'closed' ? 'selected' : '' }}>{{ __('Fechado') }}</option>
                    </select>
                </div>
            @endif

            @if($action === '')
                <div class="card">
                    <ul><b>Status Atual:</b></ul>
                    <br>
                    <select id="funcaodrop" class="dropdown2" name="status" required>
                        <option value="open" {{ old('status', $malfunction->ticket->status) == 'open' ? 'selected' : '' }}>{{ __('Aberto') }}</option>
                        <option value="in_progress" {{ old('status', $malfunction->ticket->status) == 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                        <option value="closed" {{ old('status', $malfunction->ticket->status) == 'closed' ? 'selected' : '' }}>{{ __('Fechado') }}</option>
                    </select>
                </div>
            @endif

            @if($action === 'fechar' || $action === 'abrir' || $action === '')
            <div class="card">
                <ul><b>Urgência:</b></ul>
                <br>
                <select id="funcaodrop" class="dropdown2" name="urgent" required
                         >
                    <option value="0" {{ old('urgent', $malfunction->ticket->urgent ?? 0) == 0 ? 'selected' : '' }}>{{ __('Não') }}</option>
                    <option value="1" {{ old('urgent', $malfunction->ticket->urgent ?? 0) == 1 ? 'selected' : '' }}>{{ __('Sim') }}</option>
                </select>
            </div>
            @endif

            @if($action === 'fechar' || $action === 'abrir' || $action === '')
            <div class="card">
                <ul><b>Diagnóstico:</b>
                    <br><br>
                    <textarea name="diagnosis" id="areadiagnostico" required>{{ old('diagnosis', $malfunction->diagnosis ?? '') }}</textarea>
                </ul>
            </div>
            @endif

            @if($action === 'fechar' || $action === '')
                <div class="card">
                    <ul><b>Custo:</b>
                        <input type="number" name="cost" value="{{ old('cost', $malfunction->cost ?? '') }}" required>
                    </ul>
                </div>
            @endif

            @if($action === 'fechar' || $action === '')
            <div class="card">
                <section class="cardinterior">
                    <div>
                        <ul><b>Solução da Avaria:</b></ul>
                        <br>
                        <textarea name="solution" id="areadiagnostico" required>{{ old('solution', $malfunction->solution ?? '') }}</textarea>
                    </div>
                </section>
            </div>
            @endif


            <div class="botaospace">
                <input class="botao" type="submit" value="Gravar">
            </div>

            <div class="botaospace">
                <a href="{{ route('dashboard') }}">
                    <input class="botao2" type="button" value="Cancelar">
                </a>
            </div>
        </form>
    </div>
</section>

</body>
</html>
