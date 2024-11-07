<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/listarelatoriosAdmin.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Relatório de Avarias') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="pesquisa-ordenar">
            <div class="search-box">
                <form action="{{ route('malfunctions.index') }}" method="GET">
                    <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                    <input type="search" name="search" class="input-search" placeholder="Pesquisar" aria-label="Search" />
                </form>
            </div>

            <div>
                <form method="GET" action="{{ route('malfunctions.index') }}">
                    <label for="status">{{ __('Filtrar por Status:') }}</label>
                    <select name="status" onchange="this.form.submit()" class="form-select">
                        @foreach(['' => 'Todas as Avarias', 'open' => 'Abertas', 'in_progress' => 'Em Curso', 'closed' => 'Fechadas'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="insidecontainer1">
            <table>
                <thead>
                <tr>
                    <th>
                        <button class="order">
                            <a href="{{ route('malfunctions.index', ['sort' => 'equipment_type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Equipamento') }}
                                @if (request('sort') === 'equipment_type')
                                    @if (request('direction') === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </button>
                    </th>
                    <th>
                        <button class="order">
                            <a href="{{ route('malfunctions.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Status') }}
                                @if (request('sort') === 'status')
                                    @if (request('direction') === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </button>
                    </th>
                    <th>
                        <button class="order">
                            <a href="{{ route('malfunctions.index', ['sort' => 'technician_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Técnico') }}
                                @if (request('sort') === 'technician_name')
                                    @if (request('direction') === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </button>
                    </th>
                    <th>
                        <button class="order">
                            <a href="{{ route('malfunctions.index', ['sort' => 'diagnosis', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Diagnóstico') }}
                                @if (request('sort') === 'diagnosis')
                                    @if (request('direction') === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </button>
                    </th>
                    <th>
                        <button class="order">
                            <a href="{{ route('malfunctions.index', ['sort' => 'resolution_time', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Tempo de Resolução') }}
                                @if (request('sort') === 'resolution_time')
                                    @if (request('direction') === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                @endif
                            </a>
                        </button>
                    </th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($malfunctions as $malfunction)
                    <tr>
                        <td>{{ $malfunction->equipment->type ?? 'N/A' }}</td>
                        <td>{{ $malfunction->ticket->status ?? 'N/A' }}</td>
                        <td>{{ $malfunction->ticket->technician->user->name ?? 'Sem técnico' }}</td>
                        <td>{{ $malfunction->diagnosis ?? 'N/A' }}</td>
                        <td>{{ (int) optional($malfunction->ticket)->resolution_time ?? 0 }} minuto(s)</td>
                        <td>
                            <a href="{{ route('malfunctions.show', $malfunction->id) }}">
                                <button class="botao4">Mostrar Relatório</button>
                            </a>
                            <form action="{{ route('malfunctions.destroy', $malfunction->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja eliminar esta avaria?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="botao">Eliminar</button>
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
</section>

</body>
</html>
