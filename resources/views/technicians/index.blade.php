<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Técnicos') }}
        </h2>

        <div class="d-flex align-items-center">
            <form action="{{ route('technicians.index') }}" method="GET" class="input-group" style="display: flex; justify-content: flex-end;">
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
                            <th class="px-4 py-2">{{ __('Nome do Técnico') }}</th>
                            <th class="px-4 py-2">{{ __('Email') }}</th>
                            <th class="px-4 py-2">{{ __('Especialidade') }}</th>
                            <th class="px-4 py-2">{{ __('Total de Tickets') }}</th>
                            <th class="px-4 py-2">{{ __('Ações') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($technicians as $technician)
                            <tr>
                                <td class="border px-4 py-2">{{ $technician->user->name ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $technician->user->email ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $technician->specialty ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $technician->tickets->count() }}</td>
                                <td class="border px-4 py-2"><a href="{{ route('technicians.show', $technician->id) }}">{{ __('Perfil') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $technicians->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
