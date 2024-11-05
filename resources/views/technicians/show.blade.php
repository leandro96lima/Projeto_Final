<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-9xl">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <div>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Informações de Perfil do Técnico') }}
                                </h2>
                            </header>

                            <div class="mt-6 space-y-6">
                                <!-- Nome -->
                                <div>
                                    <x-input-label for="name" :value="__('Nome')" />
                                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $technician->user->name }}</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $technician->user->email }}</p>
                                </div>

                                <!-- Especialidade -->
                                <div>
                                    <x-input-label for="specialty" :value="__('Especialidade')" />
                                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $technician->specialty }}</p>
                                </div>

                                <!-- Botões de editar e eliminar -->
                                <div class="mt-6 flex space-x-4">
                                    <!-- Botão de editar -->
                                    <a href="{{ route('technicians.edit', $technician->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        {{ __('Editar') }}
                                    </a>

                                    <!-- Botão de eliminar -->
                                    <form action="{{ route('technicians.destroy', $technician->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este técnico?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
