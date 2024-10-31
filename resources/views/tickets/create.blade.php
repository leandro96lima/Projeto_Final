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
                                <input type="text" id="room" name="room" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" readonly>
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
        // Variáveis e Dados Iniciais
        const equipmentData = @json($equipments); // Dados dos equipamentos passados do backend
        const fromPartial = @json(session('from_partial')); // Obtém o valor da sessão

        // Função: Alternar Exibição de Conteúdo
        function togglePartialDisplay() {
            const selectedType = document.getElementById('type').value.toUpperCase();
            const selectedSerial = document.getElementById('serial_number').value;
            const shouldShowPartial = (selectedType === 'OTHER' || selectedSerial === 'NEW' || fromPartial === 'user-create-equipment');

            // Exibe ou oculta os conteúdos com base na condição
            document.getElementById('formContent').style.display = shouldShowPartial ? 'none' : 'block';
            document.getElementById('partialContent').style.display = shouldShowPartial ? 'block' : 'none';

            // Atualiza o valor de 'selectedType' no campo da partial, se necessário
            if (shouldShowPartial) {
                const typeInput = document.querySelector('#partialContent input[name="type"]');

                // Verifica se o campo 'type' está vazio antes de definir o novo valor
                if (!typeInput.value) {
                    typeInput.value = selectedType;
                }
            }
        }

        // Função: Atualizar Números de Série
        function updateSerialNumbers() {
            const typeSelect = document.getElementById('type');
            const serialNumberSelect = document.getElementById('serial_number');
            const selectedType = typeSelect.value;

            // Limpa o dropdown de números de série
            serialNumberSelect.innerHTML = '<option value="">Selecione um Número de Série</option>';

            // Filtra os equipamentos com base no tipo selecionado e adiciona ao dropdown
            const filteredEquipments = equipmentData.filter(equipment => equipment.type === selectedType);
            if (filteredEquipments.length > 0) {
                filteredEquipments.forEach(equipment => {
                    const option = document.createElement('option');
                    option.value = equipment.serial_number;
                    option.textContent = equipment.serial_number;
                    serialNumberSelect.appendChild(option);
                });
            } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Nenhum número de série disponível';
                serialNumberSelect.appendChild(option);
            }

            const newOption = document.createElement('option');
            newOption.value = 'NEW';
            newOption.textContent = 'Novo';
            serialNumberSelect.appendChild(newOption);
        }

        // Função: Atualizar Sala com Base no Número de Série
        function updateRoomBasedOnSerial() {
            const serialNumberSelect = document.getElementById('serial_number');
            const roomInput = document.getElementById('room');
            const selectedSerial = serialNumberSelect.value;

            roomInput.value = '';
            roomInput.readOnly = false;

            const selectedEquipment = equipmentData.find(equipment => equipment.serial_number === selectedSerial);

            if (selectedEquipment && selectedEquipment.room) {
                roomInput.value = selectedEquipment.room;
                roomInput.readOnly = true;
            }
        }

        // Adiciona eventos de mudança
        document.getElementById('type').addEventListener('change', () => {
            updateSerialNumbers(); // Atualiza o dropdown de números de série
            togglePartialDisplay(); // Atualiza a exibição do conteúdo
        });

        document.getElementById('serial_number').addEventListener('change', () => {
            updateRoomBasedOnSerial(); // Atualiza a sala com base no número de série
            togglePartialDisplay(); // Atualiza a exibição do conteúdo
        });

        // Chama a função para garantir que a exibição do partialContent seja atualizada na carga da página
        togglePartialDisplay();
    </script>
</x-app-layout>
