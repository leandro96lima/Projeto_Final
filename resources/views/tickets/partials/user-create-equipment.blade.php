<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form id="equipment-form" action="{{ route('equipments.store') }}" method="POST">
                    @csrf

                    <!-- Campo oculto para indicar a origem do request -->
                    <input type="hidden" name="from_partial" value="user-create-equipment">

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Tipo') }}</label>
                        <input type="text" id="type" name="type" value="{{ old('type', $other_type ?? '') }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                        @error('type')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4" id="newTypeContainer">
                        <label for="new_type" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Novo Tipo de Equipamento') }}</label>
                        <input type="text" id="new_type" name="new_type" value="{{ old('new_type', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                    </div>

                    <div class="mb-4">
                        <label for="manufacturer" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Fabricante') }}</label>
                        <input type="text" id="manufacturer" name="manufacturer" value="{{ old('manufacturer', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('manufacturer')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Modelo') }}</label>
                        <input type="text" id="model" name="model" value="{{ old('model', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('model')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="serial_number" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Número de Série') }}</label>
                        <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('serial_number')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="room" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Sala') }}</label>
                        <input type="text" id="room" name="room" value="{{ old('room', '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                        @error('room')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-primary">{{ __('Criar Equipamento') }}</button>
                        <a href="{{ route('tickets.create') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Captura o campo de tipo e o campo novo tipo
        const typeInput = document.getElementById('type');
        const newTypeContainer = document.getElementById('newTypeContainer');

        // Função para verificar o valor do tipo selecionado
        function checkType() {
            // Verifica se o valor do tipo é 'OTHER'
            if (typeInput.value !== 'OTHER') { // Altere 'OTHER' para o valor que deseja verificar
                newTypeContainer.style.display = 'none'; // Oculta o campo de novo tipo
            } else {
                newTypeContainer.style.display = 'block'; // Exibe o campo de novo tipo
            }
        }

        // Inicializa a verificação ao carregar a página
        checkType();

        // Adiciona um listener para mudanças no campo de tipo
        typeInput.addEventListener('input', checkType);
    });
</script>
