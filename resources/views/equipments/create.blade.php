<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/add.equipamento.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <title>QuickFix</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header class="titulo">
    <main>
        <h1>{{ __('Adicionar Equipamento') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <form action="{{ route('equipments.store') }}" method="POST">
            @csrf

            <div class="card">
                <h4>{{__('Tipo de Equipamento:')}}</h4>
                <br>
                    <select id="type" name="type" required>
                        <option value="">Selecione um Tipo de Equipamento</option>
                        @foreach(App\Enums\EquipmentType::cases() as $equipmentType)
                            <option value="{{ $equipmentType->value }}" {{ old('type') == $equipmentType->value ? 'selected' : '' }}>{{ $equipmentType->name }}</option>
                        @endforeach
                        <option value="NEW" {{ old('type') == 'NEW' ? 'selected' : '' }}>{{ __('NEW') }}</option>
                    </select>
                @error('type')
                <span class="erro">{{ $message }}</span>
                @enderror
            </div>


            <div class="card" id="newTypeContainer" style="display: {{ old('type') == 'NEW' ? 'block' : 'none' }};">
                <ul><b>Novo Tipo de Equipamento:</b>
                    <input type="text" id="new_type" name="new_type" value="{{ old('new_type') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                </ul>
            </div>

            <div class="card">
                <ul><b>Fabricante:</b>
                    <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}" required>
                    @error('manufacturer')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Modelo:</b>
                    <input type="text" name="model" id="model" value="{{ old('model') }}" required>
                    @error('model')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Serial Number:</b>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" required>
                    @error('serial_number')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <ul><b>Sala:</b>
                    <input type="text" name="room" id="room" value="{{ old('room') }}">
                    @error('room')
                    <span class="erro">{{ $message }}</span>
                    @enderror
                </ul>
            </div>

            <div class="card">
                <section class="cardinterior">
                    <div class="botaospace">
                        <button type="submit" class="botao">{{ __('Gravar') }}</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectedType = document.getElementById('type').value;
        const newTypeContainer = document.getElementById('newTypeContainer');

        newTypeContainer.style.display = selectedType === 'NEW' ? 'block' : 'none';

        document.getElementById('type').addEventListener('change', function() {
            newTypeContainer.style.display = this.value === 'NEW' ? 'block' : 'none';
        });
    });
</script>
</body>

</html>
