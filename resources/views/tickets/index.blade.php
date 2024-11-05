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
                        @foreach(['' => 'Todos os tickets', 'pending_approval' => 'Pendentes', 'open' => 'Abertos', 'in_progress' => 'Em Curso', 'closed' => 'Fechados'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="d-flex align-items-center">
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Criar Novo Ticket</a>
            <form action="{{ route('tickets.index') }}" method="GET" class="input-group" style="display: flex; justify-content: flex-end;">
                <input type="search" name="search" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>Pesquisar</button>
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
                            <th class="px-4 py-2">
                                <a href="{{ route('tickets.index', ['sort' => 'equipment_type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Equipamento') }}
                                    @if (request('sort') === 'equipment_type')
                                        @if (request('direction') === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('tickets.index', ['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Avaria') }}
                                    @if (request('sort') === 'title')
                                        @if (request('direction') === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('tickets.index', ['sort' => 'open_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Data de Abertura') }}
                                    @if (request('sort') === 'open_date')
                                        @if (request('direction') === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('tickets.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Status') }}
                                    @if (request('sort') === 'status')
                                        @if (request('direction') === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('tickets.index', ['sort' => 'wait_time', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Tempo de Espera') }}
                                    @if (request('sort') === 'wait_time')
                                        @if (request('direction') === 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">{{ __('Ações') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="border px-4 py-2">{{ $ticket->malfunction ? $ticket->malfunction->equipment->type : 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $ticket->title }}</td>
                                <td class="border px-4 py-2">{{ $ticket->open_date }}</td>
                                <td class="border px-4 py-2">{{ $ticket->status ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $ticket->wait_time !== null ? $ticket->wait_time : 'Em espera para iniciar' }} minuto(s) </td>
                                <td class="border px-4 py-2 inline-flex items-center">
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('tickets.show', [$ticket->id]) }}'">Detalhes</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'abrir']) }}'">Iniciar Reparo</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('malfunctions.edit', [$ticket->id, 'action' => 'fechar']) }}'">Concluir Reparo</button>
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja eliminar este ticket?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-1">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
