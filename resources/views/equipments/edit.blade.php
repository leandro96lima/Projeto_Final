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
    <title>QuickFix - Editar Equipamento</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header class="titulo">
    <main>
        <h1>{{ __('Editar Equipamento') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="card">
            <ul><b>IDEquipamento:</b> {{ $equipment->id ?? 'N/A' }}</ul>
        </div>
        <form action="{{ route('equipments.update', $equipment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <ul><b>Tipo:</b>
                    <input type="text" name="type" id="type" value="{{ old('type', $equipment->type) }}" required>
                    @error('type')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Fabricante:</b>
                    <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer', $equipment->manufacturer) }}" required>
                    @error('manufacturer')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Modelo:</b>
                    <input type="text" name="model" id="model" value="{{ old('model', $equipment->model) }}" required>
                    @error('model')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Serial Number:</b>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}" required>
                    @error('serial_number')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Sala:</b>
                    <input type="text" name="room" id="room" value="{{ old('room', $equipment->room) }}">
                    @error('room')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <section class="cardinterior">
                    <div class="botaospace">
                        <button class="botao" type="submit">{{ __('Gravar') }}</button>
                    </div>
                    <div class="botaospace">
                        <a href="{{ route('equipments.index') }}">
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
