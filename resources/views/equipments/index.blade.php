<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Listagem de Equipamentos') }}</h2>
        </div>
    </x-slot>

    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th class="text-white">{{ __('Type') }}</th>
            <th class="text-white">{{ __('Manufacturer') }}</th>
            <th class="text-white">{{ __('Model') }}</th>
            <th class="text-white">{{ __('Room') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($equipments as $equipment)
            <tr>
                @foreach (['type', 'manufacturer', 'model', 'room'] as $attribute)
                    <td class="text-white">{{ $equipment->$attribute }}</td> <!-- White text for each attribute -->
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

</x-app-layout>
