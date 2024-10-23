<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Técnico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('technicians.update', $technician->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Nome') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $technician->user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Email') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $technician->user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="specialty" class="block text-sm font-medium text-white bg-gray-800 p-1 rounded">{{ __('Especialidade') }}</label>
                            <select id="specialty" name="specialty" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50 text-black" required>
                                <option value="Electrical" {{ old('specialty', $technician->specialty) == 'Electrical' ? 'selected' : '' }}>{{ __('Electrical') }}</option>
                                <option value="Mechanical" {{ old('specialty', $technician->specialty) == 'Mechanical' ? 'selected' : '' }}>{{ __('Mechanical') }}</option>
                                <option value="Software" {{ old('specialty', $technician->specialty) == 'Software' ? 'selected' : '' }}>{{ __('Software') }}</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="btn btn-primary">{{ __('Atualizar Técnico') }}</button>
                            <a href="{{ route('technicians.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

