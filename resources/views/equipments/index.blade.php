
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



<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight me-3">
                {{ __('Lista de Equipamentos') }}
            </h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('equipments.create') }}" class="btn btn-success me-2">Criar Novo Equipamento</a>
                <form action="{{ route('equipments.index') }}" method="GET" class="input-group" style="display: flex; justify-content: flex-end;">
                    <input type="search" name="search" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" aria-describedby="search-addon" />
                    <button type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>Pesquisar</button>
                </form>
            </div>
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
                                <a href="{{ route('equipments.index', ['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Tipo') }}
                                    @if(request('sort') == 'type')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('equipments.index', ['sort' => 'manufacturer', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Fabricante') }}
                                    @if(request('sort') == 'manufacturer')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('equipments.index', ['sort' => 'model', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Modelo') }}
                                    @if(request('sort') == 'model')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('equipments.index', ['sort' => 'serial_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Serial Number') }}
                                    @if(request('sort') == 'serial_number')
                                        @if(request('direction') == 'asc')
                                            ↑
                                        @else
                                            ↓
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-2">
                                <a href="{{ route('equipments.index', ['sort' => 'room', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                    {{ __('Sala') }}
                                    @if(request('sort') == 'room')
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
                        @foreach ($equipments as $equipment)
                            <tr>
                                <td class="border px-4 py-2">{{ $equipment->type ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->manufacturer ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->model ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->serial_number ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->room ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 inline-flex items-center">
                                    <button type="button" class="btn btn-success mx-1" onclick="window.location.href='{{ route('equipments.show', $equipment->id) }}'">Detalhes</button>
                                    <button type="button" class="btn btn-warning mx-1" onclick="window.location.href='{{ route('equipments.edit', $equipment->id) }}'">Editar</button>
                                    <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST" class="inline-block mx-1" onsubmit="return confirm('Tem certeza que deseja eliminar este equipamento?')">
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
                        {{ $equipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
