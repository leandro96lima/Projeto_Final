<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Equipamentos') }}
        </h2>
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
                            <th class="px-4 py-2">{{ __('Sala') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($equipments as $equipment)
                            <tr>
                                <td class="border px-4 py-2">{{ $equipment->type ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->manufacturer ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->model ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $equipment->room ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
