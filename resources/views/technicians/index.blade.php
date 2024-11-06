<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/Admin_listatecnico.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
    <title>QuickFix - Lista de Técnicos</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{ __('Lista de Técnicos') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <!-- Pesquisa e ordenação -->
        <div class="pesquisa-ordenar">
            <div class="search-box">
            <form action="{{ route('technicians.index') }}" method="GET" class="input-group">
                <input type="text" name="search" class="input-search" placeholder="Pesquisar" value="{{ request('search') }}" aria-label="Pesquisar" />
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            </div>
        </div>

        <!-- Tabela de técnicos -->
        <div class="insidecontainer1">
            <table>
                <thead>
                <tr>
                    <th><a href="{{ route('technicians.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">Nome
                            @if(request('sort') === 'name') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif
                        </a>
                    </th>
                    <th><a href="{{ route('technicians.index', ['sort' => 'email', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">Email
                            @if(request('sort') === 'email') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif
                        </a>
                    </th>
                    <th><a href="{{ route('technicians.index', ['sort' => 'specialty', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">Especialidade
                            @if(request('sort') === 'specialty') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif
                        </a>
                    </th>
                    <th><a href="{{ route('technicians.index', ['sort' => 'tickets_count', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">Total de Tickets
                            @if(request('sort') === 'tickets_count') {{ request('direction') === 'asc' ? '↑' : '↓' }} @endif
                        </a>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($technicians as $technician)
                    <tr>
                        <td>{{ $technician->user->name ?? 'N/A' }}</td>
                        <td>{{ $technician->user->email ?? 'N/A' }}</td>
                        <td>{{ $technician->specialty ?? 'N/A' }}</td>
                        <td>{{ $technician->tickets_count }}</td>
                        <td>
                            <a href="{{ route('technicians.show', $technician->id) }}">
                                <button class="botao" type="button">Perfil</button>
                            </a>
                            <form action="/delete_user" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="user_id" value="{{ $technician->id }}">
                                <button class="botao2" type="submit">Eliminar Técnico</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $technicians->links() }}
            </div>
        </div>
    </div>
</section>
</body>

</html>
