<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes da Avaria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <p><strong>{{ __('Equipamento') }}</strong> {{ $malfunction->equipment->type ?? 'N/A' }}</p>
                        <p><strong>{{ __('Diagnóstico:') }}</strong> {{ $malfunction->diagnosis ?? 'N/A' }}</p>
                        <p><strong>{{ __('Técnico') }}</strong> {{ $malfunction->technician->user->name ?? 'N/A' }}</p>
                        <p><strong>{{ __('Status:') }}</strong> {{ $malfunction->status ?? 'N/A' }}</p>
                        <p><strong>{{ __('Solução:') }}</strong> {{ $malfunction->solution ?? 'N/A' }}</p>
                        <p><strong>{{ __('Custo:') }}</strong> {{ $malfunction->cost ?? 'N/A' }}</p>
                        <p><strong>{{ __('Tempo de Resolução:') }}</strong> {{ $malfunction->resolution_time ?? 'N/A' }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('malfunctions.index') }}" class="btn btn-secondary">{{ __('Voltar à Lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
