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
        // #region Variáveis e Dados Iniciais
        const equipmentData = @json($equipments); // Dados dos equipamentos passados do backend
        // #endregion

        // #region Função: Alternar Exibição de Conteúdo
        /**
         * Alterna a exibição dos conteúdos com base no tipo e no número de série selecionado.
         * Exibe 'partialContent' quando o tipo é 'OTHER' ou o número de série é 'NEW'.
         */
        function togglePartialDisplay() {
            const selectedType = document.getElementById('type').value.toUpperCase(); // Tipo selecionado em maiúsculas
            const selectedSerial = document.getElementById('serial_number').value; // Número de série selecionado
            const shouldShowPartial = (selectedType === 'OTHER' || selectedSerial === 'NEW'); // Condição para exibição parcial

            // Exibe ou oculta os conteúdos com base na condição
            document.getElementById('formContent').style.display = shouldShowPartial ? 'none' : 'block';
            document.getElementById('partialContent').style.display = shouldShowPartial ? 'block' : 'none';

            // Atualiza o valor do tipo no campo da partial, se necessário
            if (shouldShowPartial) {
                document.querySelector('#partialContent input[name="type"]').value = selectedType;
            }
        }
        // #endregion

        // #region Função: Atualizar Números de Série
        /**
         * Atualiza as opções do dropdown de números de série com base no tipo selecionado.
         * Adiciona a opção "Novo" sempre ao final do dropdown.
         */
        function updateSerialNumbers() {
            const typeSelect = document.getElementById('type'); // Elemento do select de tipo
            const serialNumberSelect = document.getElementById('serial_number'); // Elemento do select de número de série
            const selectedType = typeSelect.value; // Obtém o tipo selecionado

            // Limpa o dropdown de números de série
            serialNumberSelect.innerHTML = '<option value="">Selecione um Número de Série</option>';

            // Filtra os equipamentos com base no tipo selecionado e adiciona ao dropdown
            const filteredEquipments = equipmentData.filter(equipment => equipment.type === selectedType);
            if (filteredEquipments.length > 0) {
                filteredEquipments.forEach(equipment => {
                    const option = document.createElement('option'); // Cria uma nova opção
                    option.value = equipment.serial_number; // Define o valor como número de série do equipamento
                    option.textContent = equipment.serial_number; // Define o texto como número de série
                    serialNumberSelect.appendChild(option); // Adiciona a opção ao dropdown
                });
            } else {
                // Exibe uma opção de erro caso não haja números de série disponíveis
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Nenhum número de série disponível';
                serialNumberSelect.appendChild(option);
            }

            // Adiciona sempre a opção "Novo" ao final do dropdown
            const newOption = document.createElement('option');
            newOption.value = 'NEW';
            newOption.textContent = 'Novo';
            serialNumberSelect.appendChild(newOption);
        }
        // #endregion

        // #region Eventos de Mudança
        // Adiciona eventos de mudança ao select de tipo e número de série
        document.getElementById('type').addEventListener('change', () => {
            updateSerialNumbers(); // Atualiza o dropdown de números de série
            togglePartialDisplay(); // Atualiza a exibição do conteúdo
        });
        document.getElementById('serial_number').addEventListener('change', togglePartialDisplay); // Atualiza a exibição do conteúdo ao mudar o número de série
        // #endregion
    </script>
</x-app-layout>
