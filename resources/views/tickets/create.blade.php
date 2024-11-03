<x-app-layout>
    <x-slot name="header"> <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Novo Ticket') }}</h2> </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="formContent" class="p-6">
                    @if ($errors->has('ticket'))
                        <div class="text-red-600 mb-4"><strong>{{ $errors->first('ticket') }}</strong></div>
                    @endif

                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        @foreach (['type' => 'Tipo de Equipamento', 'serial_number' => 'Número de Série'] as $field => $label)
                            <div class="mb-4">
                                <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">{{ __($label) }}</label>
                                @if(isset(${'other_' . $field}))
                                    <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ ${'other_' . $field} }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                @else
                                    <select id="{{ $field }}" name="{{ $field }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                        <option value="">Selecione um {{ strtolower($label) }}</option>
                                        @if($field === 'type')
                                            @foreach($equipmentTypes as $equipmentType)
                                                <option value="{{ $equipmentType->value }}" {{ old($field) === $equipmentType->value ? 'selected' : '' }}>{{ $equipmentType->name }}</option>
                                            @endforeach
                                            <option value="OTHER" {{ old($field) === 'OTHER' ? 'selected' : '' }}>OTHER</option>
                                        @else
                                            <option value="">Nenhum disponível</option>
                                        @endif
                                    </select>
                                @endif
                                @error($field) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        @foreach (['room' => 'Sala', 'title' => 'Título'] as $field => $label)
                            <div class="mb-4">
                                <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">{{ __($label) }}</label>
                                <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" @if($field === 'room') readonly @endif>
                                @error($field) <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Descrição') }}</label>
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
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
        const equipmentData = @json($equipments);
        const fromPartial = @json(session('from_partial'));

        // Função: Alternar Exibição de Conteúdo
        const togglePartialDisplay = () => {
            const selectedType = document.getElementById('type').value.toUpperCase();
            const selectedSerial = document.getElementById('serial_number').value;
            const shouldShowPartial = selectedType === 'OTHER' || selectedSerial === 'NEW' || fromPartial === 'user-create-equipment';

            document.getElementById('formContent').style.display = shouldShowPartial ? 'none' : 'block';
            document.getElementById('partialContent').style.display = shouldShowPartial ? 'block' : 'none';

            if (shouldShowPartial) {
                const typeInput = document.querySelector('#partialContent input[name="type"]');
                if (!typeInput.value) typeInput.value = selectedType;
            }
        };

        // Função: Atualizar Números de Série
        const updateSerialNumbers = () => {
            const typeSelect = document.getElementById('type');
            const serialNumberSelect = document.getElementById('serial_number');
            const selectedType = typeSelect.value;

            serialNumberSelect.innerHTML = '<option value="">Selecione um Número de Série</option>';
            const filteredEquipments = equipmentData.filter(e => e.type === selectedType && e.is_approved);

            filteredEquipments.forEach(equipment => {
                const option = new Option(equipment.serial_number, equipment.serial_number);
                serialNumberSelect.add(option);
            });

            const noOption = new Option(filteredEquipments.length > 0 ? 'Novo' : 'Nenhum número de série disponível', filteredEquipments.length > 0 ? 'NEW' : '');
            serialNumberSelect.add(noOption);
        };

        // Função: Atualizar Sala com Base no Número de Série
        const updateRoomBasedOnSerial = () => {
            const serialNumberSelect = document.getElementById('serial_number');
            const roomInput = document.getElementById('room');
            const selectedEquipment = equipmentData.find(e => e.serial_number === serialNumberSelect.value);

            roomInput.value = selectedEquipment?.room || '';
            roomInput.readOnly = !!selectedEquipment?.room;
        };

        // Adiciona eventos de mudança
        document.getElementById('type').addEventListener('change', () => {
            updateSerialNumbers();
            togglePartialDisplay();
        });

        document.getElementById('serial_number').addEventListener('change', () => {
            updateRoomBasedOnSerial();
            togglePartialDisplay();
        });

        // Chama as funções ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            togglePartialDisplay();
            updateSerialNumbers();
        });
    </script>
</x-app-layout>
