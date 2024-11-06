<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/Editar_equipamento.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>QuickFix</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header class="titulo">
    <main>
        <h1>{{ __('Editar Técnico') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="card">
            <ul><b>ID Técnico:</b>
                {{ $technician->id }} <!-- Exibindo o ID do Técnico -->
            </ul>
        </div>

        <!-- Formulário de Edição de Técnico -->
        <form action="{{ route('technicians.update', $technician->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <ul><b>Nome:</b>
                    <input type="text" name="name" id="Nometécnico" value="{{ old('name', $technician->user->name) }}" required readonly>
                </ul>
            </div>

            <div class="card">
                <ul><b>Email:</b>
                    <input type="email" name="email" id="Email-técnico" value="{{ old('email', $technician->user->email) }}" required readonly>
                </ul>
            </div>

            <div class="card">
                <ul><b>Total de tickets:</b>
                    {{ count($technician->tickets) }} <!-- Exibindo o total de tickets do técnico -->
                </ul>
            </div>

            <div class="card">
                <ul><b>Especialidade:</b></ul>
                <select id="funcaodrop" class="dropdown" name="specialty" required>
                    <option value="Electrical" {{ old('specialty', $technician->specialty) == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                    <option value="Mechanical" {{ old('specialty', $technician->specialty) == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                    <option value="Software" {{ old('specialty', $technician->specialty) == 'Software' ? 'selected' : '' }}>Software</option>
                </select>
            </div>

            <div class="card">
                <section class="cardinterior">
                    <div class="botaospace">
                        <button type="submit" class="botao">Gravar</button>
                    </div>

                    <div class="botaospace">
                        <a href="{{ route('technicians.index') }}">
                            <input class="botao2" type="button" value="Cancelar">
                        </a>
                    </div>
                </section>
            </div>
        </form>
    </div>
</section>

</body>
</html>
