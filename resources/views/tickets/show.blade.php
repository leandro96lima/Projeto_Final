<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"> {{ __('Detalhes do Ticket') }} </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        @php
                            $ticketDetails = [
                                __('Data de abertura:') => $ticket->open_date ?: 'N/A',
                                __('Equipamento') => optional($ticket->malfunction->equipment)->type ?: 'N/A',
                                __('Serial Number:') => optional($ticket->malfunction->equipment)->serial_number ?: 'N/A',
                                __('Sala:') => optional($ticket->malfunction->equipment)->room ?: 'N/A',
                                __('Tempo de Espera:') => $ticket->malfunction ? ($ticket->wait_time !== null ? $ticket->wait_time . ' minuto(s)' : 'Em espera para iniciar') : 'Em espera para iniciar',
                                __('Status:') => $ticket->status ?: 'N/A',
                                __('Avaria:') => $ticket->title ?: 'N/A',
                                __('Descrição:') => $ticket->description ?: 'N/A',
                                __('Diagnóstico:') => $ticket->malfunction->diagnosis ?: 'N/A',
                                __('Solução:') => $ticket->malfunction->solution ?: 'N/A',
                                __('Custo:') => $ticket->malfunction->cost ?: 'N/A',
                            ];
                        @endphp
                        @foreach ($ticketDetails as $label => $value)
                            <p><strong>{{ $label }}</strong> {{ $value }}</p>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('Voltar à Lista') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
