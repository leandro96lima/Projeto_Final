<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Avarias') }}
        </h2>

        <div class="ml-auto w-48">
            <form method="GET" action="{{ route('malfunctions.index') }}">
                <label for="status" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Filtrar por Status') }}</label>
                <select name="status" onchange="this.form.submit()" class="form-select">
                    <option value="">{{ __('Todas as Avarias') }}</option>
                    <option value="open" {{ request('status')}}>{{ __('Abertas') }}</option>
                    <option value="in_progress" {{ request('status') }}>{{ __('Em Curso') }}</option>
                    <option value="closed" {{ request('status') }}>{{ __('Fechadas') }}</option>
                </select>
            </form>
        </div>

        <div class="d-flex align-items-center">
            <form action="{{ route('malfunctions.index') }}" method="GET" class="input-group" style="display: flex; justify-content: flex-end;">
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
                                <a href="{{ route('malfunctions.index', ['sort' => 'equipment_type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Equipamento') }}
                                    @if(request('sort') == 'equipment_type')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('malfunctions.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Status') }}
                                    @if(request('sort') == 'status')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('malfunctions.index', ['sort' => 'technician_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Técnico') }}
                                    @if(request('sort') == 'technician_name')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('malfunctions.index', ['sort' => 'diagnosis', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Diagnóstico') }}
                                    @if(request('sort') == 'diagnosis')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('malfunctions.index', ['sort' => 'resolution_time', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Tempo de Resolução') }}
                                    @if(request('sort') == 'resolution_time')
                                        @if(request('direction') == 'asc')
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
                        @foreach ($malfunctions as $malfunction)
                            <tr>
                                <td class="border px-4 py-2">{{ $malfunction->equipment->type ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->ticket->status ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->technician->user->name ?? 'Sem técnico' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->diagnosis ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">
                                    @if ($malfunction->ticket->status === 'open')
                                        Em espera para iniciar reparo
                                    @else
                                        {{ $malfunction->ticket->resolution_time ?? 0 }} minuto(s)
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('malfunctions.show', $malfunction->id) }}">{{ __('Detalhes') }}</a>
                                    <form action="{{ route('malfunctions.destroy', $malfunction->id) }}" method="POST" class="inline-block mx-1" onsubmit="return confirm('Tem certeza que deseja eliminar esta avaria?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $malfunctions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
