<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="formContent" class="p-6">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Tipo de Equipamento') }}</label>
                            @if(isset($other_type))
                                <input type="text" id="type" name="type" value="{{ $other_type }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @else
                                <select id="type" name="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <option value="">Selecione um Tipo de Equipamento</option>
                                    @foreach($equipmentTypes as $equipmentType)
                                        <option value="{{ $equipmentType->value }}">{{ $equipmentType->name }}</option>
                                    @endforeach
                                    <option value="OTHER">OTHER</option>
                                </select>
                            @endif
                            @error('type')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">{{ __('Número de Série') }}</label>
                            @if(isset($other_serial_number))
                                <input type="text" id="serial_number" name="serial_number" value="{{ $other_serial_number }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @else
                                <select id="serial_number" name="serial_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <option value="">Selecione um Número de Série</option>
                                </select>
                            @endif
                            @error('serial_number')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="room" class="block text-sm font-medium text-gray-700">{{ __('Sala') }}</label>
                            @if(isset($other_room))
                                <input type="text" id="room" name="room" value="{{ $other_room }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @else
                                <input type="text" id="room" name="room" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @endif
                            @error('other_room')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Título') }}</label>
                            <input id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></input>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Descrição') }}</label>
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="btn btn-primary">{{ __('Criar Avaria') }}</button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>

                <div id="partialContent" style="display: none;">
                    @include('tickets.partials.user-create-equipment')
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePartialDisplay() {
            const selectedType = document.getElementById('type').value.toUpperCase();
            const selectedSerial = document.getElementById('serial_number').value;
            console.log('Selected Serial:', selectedSerial);
            const shouldShowPartial = (selectedType === 'OTHER' || selectedSerial === 'NEW');

            // Exibe ou oculta os conteúdos conforme a condição combinada
            document.getElementById('formContent').style.display = shouldShowPartial ? 'none' : 'block';
            document.getElementById('partialContent').style.display = shouldShowPartial ? 'block' : 'none';

            // Atualiza o valor de 'selectedType' no campo da partial, se necessário
            if (shouldShowPartial) {
                document.querySelector('#partialContent input[name="type"]').value = selectedType;
            }
        }

        document.getElementById('type').addEventListener('change', togglePartialDisplay);
        document.getElementById('serial_number').addEventListener('change', togglePartialDisplay);

    </script>
    <script>
        const equipmentData = @json($equipments); // Obtendo os dados dos equipamentos

        function updateSerialNumbers() {
            const typeSelect = document.getElementById('type');
            const serialNumberSelect = document.getElementById('serial_number');
            const selectedType = typeSelect.value;

            // Limpa o dropdown de números de série
            serialNumberSelect.innerHTML = '<option value="">Selecione um Número de Série</option>';



            if (selectedType) {
                // Filtra equipamentos pelo tipo selecionado
                const filteredEquipments = equipmentData.filter(equipment => equipment.type === selectedType);

                // Se houver equipamentos filtrados, adiciona seus números de série ao dropdown
                if (filteredEquipments.length > 0) {
                    filteredEquipments.forEach(equipment => {
                        const option = document.createElement('option');
                        option.value = equipment.serial_number; // Usando o número de série do equipamento
                        option.textContent = equipment.serial_number; // Usando o número de série do equipamento
                        serialNumberSelect.appendChild(option);
                    });
                } else {
                    // Caso não haja equipamentos disponíveis para o tipo selecionado
                    const option = document.createElement('option');
                    option.value = ''; // Sem valor
                    option.textContent = 'Nenhum número de série disponível'; // Mensagem de erro
                    serialNumberSelect.appendChild(option);
                }
            }

            // Adiciona sempre a opção "Novo"
            const newOption = document.createElement('option');
            newOption.value = 'NEW';
            newOption.textContent = 'Novo';
            serialNumberSelect.appendChild(newOption);
        }

        // Adiciona o evento de mudança ao select de tipo
        document.getElementById('type').addEventListener('change', updateSerialNumbers);
    </script>
</x-app-layout>
