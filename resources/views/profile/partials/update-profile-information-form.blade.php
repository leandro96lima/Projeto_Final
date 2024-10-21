<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <!-- Primeira coluna: Formulário para alteração do perfil -->
    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Update your account's profile information, email address, and user type.") }}
            </p>
        </header>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <!-- Nome -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Inputs para Token e Type em colunas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
                <!-- Coluna Token -->
                <div>
                    <x-input-label for="token" :value="__('Token for Type Change')" />
                    <x-text-input id="token" name="token" type="text" class="mt-1 block w-full" required autocomplete="off" />
                    <x-input-error class="mt-2" :messages="$errors->get('token')" />
                </div>

                <!-- Coluna Type -->
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select id="type" name="type" class="mt-1 block w-full">
                        <option value="User" {{ $user->type == 'User' ? 'selected' : '' }}>User</option>
                        <option value="Admin" {{ $user->type == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Technician" {{ $user->type == 'Technician' ? 'selected' : '' }}>Technician</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>
            </div>

            <!-- Botão de salvar -->
            <div class="mt-6">
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

    <!-- Segunda coluna: Solicitar Token ao Administrador -->
    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Request Token') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('If you need a token to change your user type, request it from an administrator.') }}
            </p>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Please check your email within the next 24 hours.') }}
            </p>
        </header>

        <form method="post" action="{{ route('profile.request-token') }}" class="mt-6 space-y-6">
            @csrf

            <!-- Motivo da Solicitação -->
            <div>
                <x-input-label for="request_reason" :value="__('Reason for Request')" />
                <textarea id="request_reason" name="request_reason" class="mt-1 block w-full" rows="3" required></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('request_reason')" />
            </div>

            <!-- Botão de Solicitação -->
            <div class="mt-6">
                <x-primary-button>{{ __('Request Token') }}</x-primary-button>

                @if (session('status') === 'token-requested')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Token request sent.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
