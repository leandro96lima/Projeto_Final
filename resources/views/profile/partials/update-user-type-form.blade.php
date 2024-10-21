    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Change User Type') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('You can update your user type by providing a valid token.') }}
            </p>
        </header>

        <!-- Div que engloba o input de token e o botão de envio, ambos em flex -->
        <div class="flex items-center gap-4 mt-6">
            <!-- Input do Token -->
            <div class="flex-grow">
                <x-input-label for="token" :value="__('Token for Type Change')" />
                <x-text-input id="token" name="token" type="text" class="mt-1 block w-full" required autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('token')" />
            </div>

            <!-- Formulário separado para enviar o token -->
            <form method="post" action="{{ route('profile.send-token') }}">
                @csrf
                <x-primary-button class="mt-6">
                    {{ __('Send Token') }}
                </x-primary-button>
            </form>
        </div>

        <!-- Formulário principal para alterar o tipo de usuário -->
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <!-- Input para seleção de tipo -->
            <div class="mt-6">
                <x-input-label for="type" :value="__('Type')" />
                <select id="type" name="type" class="mt-1 block w-full">
                    <option value="User" {{ $user->type == 'User' ? 'selected' : '' }}>User</option>
                    <option value="Admin" {{ $user->type == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Technician" {{ $user->type == 'Technician' ? 'selected' : '' }}>Technician</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('type')" />
            </div>

            <!-- Botão de salvar -->
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'type-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Type updated.') }}</p>
                @endif
            </div>
        </form>
    </div>
