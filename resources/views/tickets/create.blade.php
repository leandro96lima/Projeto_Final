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
                            @if(isset($other_type)) <!-- Verifica se 'other_type' está definido -->
                            <input type="text" id="type" name="type" value="{{  $other_type }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @else
                                <select id="type" name="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <option value="">Selecione um Tipo de Equipamento</option>
                                    @foreach($equipmentTypes as $equipmentType)
                                        <option value="{{ $equipmentType->value }}">{{ $equipmentType->name }}</option>
                                    @endforeach
                                    <option value="OTHER">Outro</option>
                                </select>
                            @endif
                            @error('type')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">{{ __('Número de Série') }}</label>
                            @if(isset($other_serial_number)) <!-- Verifica se 'other_serial_number' está definido -->
                            <input type="text" id="serial_number" name="serial_number" value="{{ $other_serial_number }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @else
                                <select id="serial_number" name="serial_number" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                                    <option value="">Selecione um Número de Série</option>
                                    <!-- Adicione as opções de números de série aqui -->
                                </select>
                            @endif
                            @error('serial_number')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Título') }}</label>
                            <textarea id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></textarea>
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

                <!-- Container para o partial -->
                <!-- Container para o partial -->
                <div id="partialContent" style="display: none;">
                    @include('tickets.partials.user-create-equipment', ['selectedType' => 'OTHER'])
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            const selectedType = this.value;

            if (selectedType === 'OTHER') {
                document.getElementById('formContent').style.display = 'none'; // Esconde o conteúdo do formulário original
                document.getElementById('partialContent').style.display = 'block'; // Exibe o partial
            } else {
                document.getElementById('formContent').style.display = 'block';
                document.getElementById('partialContent').style.display = 'none';
            }
        });
    </script>
</x-app-layout>
