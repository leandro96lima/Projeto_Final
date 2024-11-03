<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Lista de Tickets') }}</h2>
            <form method="GET" action="{{ route('tickets.index') }}" class="ml-auto w-48">
                <label class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Filtrar por Status') }}</label>
                <select name="status" onchange="this.form.submit()" class="form-select">
                    <option value="">{{ __('Todos os Tickets') }}</option>
                    @foreach(['pending_approval' => 'Pendentes', 'open' => 'Abertos', 'in_progress' => 'Em Curso', 'closed' => 'Fechados'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ __($label) }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Criar Novo Ticket</a>
            <form action="{{ route('tickets.index') }}" method="GET" class="flex">
                <input type="search" name="search" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" />
                <button type="submit" class="btn btn-outline-primary">Pesquisar</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full text-left">
                        <thead>
                        <tr>
                            @foreach(['Equipamento', 'Avaria', 'Data de Abertura', 'Status', 'Tempo de Espera', 'Ações'] as $header)
                                <th class="px-4 py-2">{{ __($header) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            @can('view', $ticket)
                                <tr>
                                    <td class="border px-4 py-2">{{$ticket->malfunction->equipment->type ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $ticket->title }}</td>
                                    <td class="border px-4 py-2">{{ $ticket->open_date }}</td>
                                    <td class="border px-4 py-2">{{ $ticket->status ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ optional($ticket)->wait_time ?? 'Em espera para iniciar' }} minuto(s)</td>
                                    <td class="border px-4 py-2 inline-flex items-center space-x-1">
                                        <button type="button" class="btn btn-warning" onclick="location.href='{{ route('tickets.show', [$ticket->id]) }}'">Detalhes</button>
                                        @can('viewAny', $ticket)
                                            <button type="button" class="btn btn-warning" onclick="location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'abrir']) }}'">Iniciar Reparo</button>
                                            <button type="button" class="btn btn-warning" onclick="location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'fechar']) }}'">Concluir Reparo</button>
                                        @endcan
                                    </td>
                                </tr>
                            @endcan
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $tickets->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
