<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <p><strong>{{ __('Equipamento') }}</strong> {{ $ticket->malfunction ? $ticket->malfunction->equipment->type : 'N/A' }}</p>
                        <p><strong>{{ __('Serial Number:') }}</strong> {{ $ticket->malfunction ? $ticket->malfunction->equipment->serial_number : 'N/A' }}</p>
                        <p><strong>{{ __('Título:') }}</strong> {{ $ticket->title ?? 'N/A' }}</p>
                        <p><strong>{{ __('Descrição:') }}</strong> {{ $ticket->description ?? 'N/A' }}</p>
                        <p><strong>{{ __('Data de abertura:') }}</strong> {{ $ticket->open_date ?? 'N/A' }}</p>
                        <p><strong>{{ __('Status:') }}</strong> {{ $ticket->malfunction->status ?? 'N/A' }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">{{ __('Voltar à Lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
