<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full text-left">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('Título') }}</th>
                            <th class="px-4 py-2">{{ __('Descrição') }}</th>
                            <th class="px-4 py-2">{{ __('Data de Abertura') }}</th>
                            <th class="px-4 py-2">{{ __('Data de Conclusão') }}</th>
                            <th class="px-4 py-2">{{ __('Urgente') }}</th>
                            <th class="px-4 py-2">{{ __('Ações') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="border px-4 py-2">{{ $ticket->title }}</td>
                                <td class="border px-4 py-2">{{ $ticket->description }}</td>
                                <td class="border px-4 py-2">{{ $ticket->open_date }}</td>
                                <td class="border px-4 py-2">{{ $ticket->close_date ?? 'Por concluir' }}</td>
                                <td class="border px-4 py-2">{{ $ticket->urgent ? 'Sim' : 'Não' }}</td>
                                <td class="border px-4 py-2 inline-flex items-center">
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('tickets.edit', $ticket->id) }}'">Abrir Avaria</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('malfunctions.edit', $ticket->id) }}'">Fechar Avaria</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

