<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        header {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.25rem; /* text-lg */
            font-weight: 500; /* font-medium */
            color: #1f2937; /* text-gray-900 */
        }

        p {
            margin-top: 0.25rem; /* mt-1 */
            font-size: 0.875rem; /* text-sm */
            color: #4b5563; /* text-gray-600 */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .button-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }



        .status-message {
            color: #4b5563; /* text-gray-600 */
            font-size: 14px;
        }
    </style>
</head>
<body>
<section>
    <header>
        <h2>{{ __('Update Password') }}</h2>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="error-message" />
        </div>

        <div class="form-group">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="error-message" />
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="error-message" />
        </div>

        <div class="button-container">
            <button type="submit" class="primary-button">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="status-message">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
</body>
</html>
