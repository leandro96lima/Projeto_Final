<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Lista de Tickets') }}
                </h2>
            </div>
            <div class="ml-auto w-48">
                <form method="GET" action="{{ route('tickets.index') }}">
                    <label for="status" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Filtrar por Status') }}</label>
                    <select name="status" onchange="this.form.submit()" class="form-select">
                        <option value="">{{ __('Todos os Tickets') }}</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Pendentes') }}</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('Em Curso') }}</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('Fechados') }}</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Criar Novo Ticket</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full text-left">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('Equipamento') }}</th>
                            <th class="px-4 py-2">{{ __('Problema') }}</th>
                            <th class="px-4 py-2">{{ __('Data de Abertura') }}</th>
                            <th class="px-4 py-2">{{ __('Status') }}</th>
                            <th class="px-4 py-2">{{ __('Ações') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="border px-4 py-2">{{ $ticket->malfunction ? $ticket->malfunction->equipment->type : 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $ticket->title }}</td>
                                <td class="border px-4 py-2">{{ $ticket->open_date }}</td>
                                <td class="border px-4 py-2">{{ $ticket->malfunction->status ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 inline-flex items-center">
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('tickets.show', [$ticket->id]) }}'">Detalhes</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'abrir']) }}'">Iniciar Reparo</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'fechar']) }}'">Concluir Reparo</button>
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

