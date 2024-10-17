<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Listagem de Avarias') }}</h2>
        </div>
    </x-slot>

    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th class="text-white">{{ __('Equipamento') }}</th>
            <th class="text-white">{{ __('Status') }}</th>
            <th class="text-white">{{ __('Custo') }}</th>
            <th class="text-white">{{ __('Tempo de resolução') }}</th>
            <th class="text-white">{{ __('Diagnóstico') }}</th>
            <th class="text-white">{{ __('Solução') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($malfunctions as $malfunction)
            <tr>
                @foreach (['status', 'cost', 'resolution_time', 'diagnosis', 'solution', 'equipment_id'] as $attribute)
                    <td class="text-white">{{ $malfunction->$attribute }}</td> <!-- White text for each attribute -->
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

</x-app-layout>
