<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('equipments.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Tipo') }}</label>

                        @if(isset($selectedType) && $selectedType === 'OTHER')
                            <!-- Se selectedType for 'OTHER', exibe um input readonly -->
                            <input type="text" id="type" name="type" value="OTHER" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                        @else
                            <!-- Se selectedType não estiver definido, exibe o select -->
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                                <option value="">Selecione um Tipo de Equipamento</option>
                                @foreach(App\Enums\EquipmentType::cases() as $equipmentType)
                                    <option value="{{ $equipmentType->value }}" >
                                        {{ $equipmentType->name }}
                                    </option>
                                @endforeach
                                <option value="OTHER" {{ __('OTHER') }}</option>
                            </select>
                        @endif

                        @error('type')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4" id="newTypeContainer">
                        <label for="new_type" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Novo Tipo de Equipamento') }}</label>
                        <input type="text" id="new_type" name="new_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                    </div>

                    <div class="mb-4">
                        <label for="manufacturer" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Fabricante') }}</label>
                        <input type="text" id="manufacturer" name="manufacturer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('manufacturer')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="model" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Modelo') }}</label>
                        <input type="text" id="model" name="model" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('model')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="serial_number" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Número de Série') }}</label>
                        <input type="text" id="serial_number" name="serial_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                        @error('serial_number')
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
