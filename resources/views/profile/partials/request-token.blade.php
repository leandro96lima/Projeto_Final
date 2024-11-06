<div class="cardtoken">
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

        <x-input-label for="requested_type" :value="__('Request Type')" />
        <select id="requested_type" name="requested_type" class="block w-half">
            <option value="User"> User</option>
            <option value="Admin"> Admin</option>
            <option value="Technician"> Technician</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('type')" />

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
