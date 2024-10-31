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
                            <th class="px-4 py-2">{{ __('Tipo') }}</th>
                            <th class="px-4 py-2">{{ __('Fabricante') }}</th>
                            <th class="px-4 py-2">{{ __('Modelo') }}</th>
                            <th class="px-4 py-2">{{ __('Serial Number') }}</th>
                            <th class="px-4 py-2">{{ __('Sala') }}</th>
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
