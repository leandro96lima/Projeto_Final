<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <!-- Primeira coluna: Formulário para alteração do perfil -->
    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __("Update your account's profile information and email address.") }}
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
        </form>
    </div>

    <!-- Segunda coluna: Formulário para alteração do tipo de usuário -->
    <div>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Change User Type') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('You can update your user type by providing a valid token.') }}
            </p>
        </header>

        <!-- Div para input de token -->
        <div class="flex items-center gap-4 mt-6">
            <!-- Input Token -->
            <div class="flex-grow">
                <x-input-label for="token" :value="__('Token for Type Change')" />
                <x-text-input id="token" name="token" type="text" class="mt-1 block w-full" required autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('token')" />
            </div>

            <!-- Botão enviar token -->
            <form method="post" action="{{ route('profile.send-token') }}">
                @csrf
                <x-primary-button class="mt-6">
                    {{ __('Send Token') }}
                </x-primary-button>
            </form>
        </div>

        <!-- Seletor de tipo de usuário -->
        <div class="mt-6">
            <x-input-label for="type" :value="__('Type')" />
            <select id="type" name="type" class="mt-1 block w-full">
                <option value="User" {{ $user->type == 'User' ? 'selected' : '' }}>User</option>
                <option value="Admin" {{ $user->type == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Technician" {{ $user->type == 'Technician' ? 'selected' : '' }}>Technician</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('type')" />
        </div>
    </div>
</div>

<!-- Botão de salvar abaixo das duas colunas -->
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
