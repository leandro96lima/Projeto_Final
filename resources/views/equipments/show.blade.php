<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Equipamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <p><strong>{{ __('Tipo:') }}</strong> {{ $equipment->type ?? 'N/A' }}</p>
                        <p><strong>{{ __('Fabricante:') }}</strong> {{ $equipment->manufacturer ?? 'N/A' }}</p>
                        <p><strong>{{ __('Modelo:') }}</strong> {{ $equipment->model ?? 'N/A' }}</p>
                        <p><strong>{{ __('Sala:') }}</strong> {{ $equipment->room ?? 'N/A' }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">{{ __('Voltar à Lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
