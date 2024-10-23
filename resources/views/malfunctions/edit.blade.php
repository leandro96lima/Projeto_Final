<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Avaria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('malfunctions.update', $malfunction->id) }}" method="POST">
                        @csrf
                        @method('PATCH') <!-- Indica que estamos atualizando -->

                        <input type="hidden" name="action" value="{{ $action }}">

                        <div class="mb-4">
                            <label for="equipment" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Equipamento') }}</label>
                            <input type="text" id="equipment" name="equipment" value="{{ old('equipment', $malfunction->equipment->type ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" disabled>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Status') }}</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                                <option value="open" {{ old('status', $malfunction->status) == 'open' ? 'selected' : '' }}>{{ __('Aberto') }}</option>
                                <option value="in_progress" {{ old('status', $malfunction->status) == 'in_progress' ? 'selected' : '' }}>{{ __('Em Progresso') }}</option>
                                <option value="closed" {{ old('status', $malfunction->status) == 'closed' ? 'selected' : '' }}>{{ __('Fechado') }}</option>
                            </select>
                            @error('status')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="urgent" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Urgência') }}</label>
                            <select id="urgent" name="urgent" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                                <option value="0" {{ old('urgent', $malfunction->urgent) == 0 ? 'selected' : '' }}>{{ __('Não') }}</option>
                                <option value="1" {{ old('urgent', $malfunction->urgent) == 1 ? 'selected' : '' }}>{{ __('Sim') }}</option>
                            </select>
                            @error('urgent')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="diagnosis" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Diagnóstico') }}</label>
                            <input type="text" id="diagnosis" name="diagnosis" value="{{ old('diagnosis', $malfunction->diagnosis ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black"
                                   @if($action == 'fechar') disabled @endif>
                            @error('diagnosis')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                         @if ($action == 'fechar')
                        <div class="mb-4">
                            <label for="solution" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Solução') }}</label>
                            <input type="text" id="solution" name="solution" value="{{ old('solution', $malfunction->solution ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                            @error('solution')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cost" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Custo') }}</label>
                            <input type="text" id="cost" name="cost" value="{{ old('cost', $malfunction->cost ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black">
                            @error('cost')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="technician" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Técnico') }}</label>
                            <input type="text" id="technician" name="technician" value="{{ old('technician', $malfunction->technician->user->name ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" disabled>
                            @error('technician')
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
