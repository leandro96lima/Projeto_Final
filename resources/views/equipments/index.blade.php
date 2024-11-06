<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/listaequipamentosAdmin.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">

    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header class="titulo">
    <main>
        <h1>{{ __('Lista de Equipamentos') }}</h1>
    </main>
</header>

<section class="container">
    <div class="insidecontainer">
        <div class="pesquisa-ordenar">
            <div class="search-box">
            <form action="{{ route('equipments.index') }}" method="GET" class="input-group">
                <input type="text" name="search" class="input-search" placeholder="Type to Search..." aria-label="Search" aria-describedby="search-addon" value="{{ request('search') }}" />
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            </form>
            </div>
        </div>

        <div class="insidecontainer1">
            <table>
                <thead>
                <tr>
                    <th><a href="{{ route('equipments.index')}}" class="order">{{ __('ID') }}</a></th>
                    <th><a href="{{ route('equipments.index', ['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="order">{{ __('Tipo') }}</a></th>
                    <th><a href="{{ route('equipments.index', ['sort' => 'manufacturer', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="order">{{ __('Fabricante') }}</a></th>
                    <th><a href="{{ route('equipments.index', ['sort' => 'model', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="order">{{ __('Modelo') }}</a></th>
                    <th><a href="{{ route('equipments.index', ['sort' => 'serial_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="order">{{ __('Serial Number') }}</a></th>
                    <th><a href="{{ route('equipments.index', ['sort' => 'room', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="order">{{ __('Sala') }}</a></th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($equipments as $equipment)
                    <tr>
                        <td>{{ $equipment->id }}</td>
                        <td>{{ $equipment->type ?? 'N/A' }}</td>
                        <td>{{ $equipment->manufacturer ?? 'N/A' }}</td>
                        <td>{{ $equipment->model ?? 'N/A' }}</td>
                        <td>{{ $equipment->serial_number ?? 'N/A' }}</td>
                        <td>{{ $equipment->room ?? 'N/A' }}</td>
                        <td id="displaybotao">
                            <div>
                                <a href="{{ route('equipments.show', $equipment->id) }}">
                                    <input class="botao4" type="button" value="Mostrar Equipamento">
                                </a>
                            </div>
                            <a href="{{ route('equipments.edit', $equipment->id) }}">
                                <input class="botao" type="button" value="Editar Equipamento">
                            </a>
                            <div>
                                <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este equipamento?')">
                                    @csrf
                                    @method('DELETE')
                                    <input class="botao2" type="submit" value="Eliminar Equipamento">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $equipments->links() }}
            </div>
        </div>
        <div class="add">
            <a href="{{ route('equipments.create') }}">
                <button class="botao3">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </a>
        </div>
    </div>
</section>
</body>
</html>
