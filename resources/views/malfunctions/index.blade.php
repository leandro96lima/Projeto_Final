<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Avarias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full text-left">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">{{ __('Equipamento') }}</th>
                            <th class="px-4 py-2">{{ __('Status') }}</th>
                            <th class="px-4 py-2">{{ __('Técnico') }}</th>
                            <th class="px-4 py-2">{{ __('Diagnóstico') }}</th>
                            <th class="px-4 py-2">{{ __('Tempo de Resolução') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($malfunctions as $malfunction)
                            <tr>
                                <td class="border px-4 py-2">{{ $malfunction->equipment->type ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->ticket->status ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->technician->user->name ?? 'Sem técnico' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->diagnosis ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $malfunction->resolution_time ?? 'N/A' }}</td>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
