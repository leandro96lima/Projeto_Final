<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Abertura de Avaria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Indica que estamos atualizando -->

                        <div class="mb-4">
                            <label for="equipment" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Equipamento') }}</label>
                            <input type="text" id="equipment" name="equipment" value="{{ old('equipment', $ticket->malfunction->equipment->type ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Status') }}</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                                <option value="open" {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>{{ __('Aberto') }}</option>
                                <option value="in_progress" {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                            </select>
                            @error('status')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="technician" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Técnico') }}</label>
                            <input type="text" id="technician" name="technician" value="{{ old('technician', $ticket->technician->user->name ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" disabled>
                            @error('technician')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Diagnóstico') }}</label>
                            <input type="text" id="diagnosis" name="diagnosis" value="{{ old('diagnosis', $ticket->malfunction->diagnosis ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                            @error('diagnosis')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="btn btn-primary">{{ __('Confirmar') }}</button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
