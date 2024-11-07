<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
        }

        header {
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
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

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Para incluir padding e border no cálculo da largura */
        }

        input[readonly] {
            background-color: #f9f9f9;
        }

        .button-container {
            margin-top: 20px;
        }

        .primary-button {
            width: 350px;
            margin: 10px;
            border-radius: 20px;
            border: 1px solid #0077ff;
            background-color: #0077ff;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            text-align: center;
        }

        .primary-button:hover {
            background-color: #0077ff;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .status-message {
            color: gray;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div>
    <header>
        <h2>
            {{ __('Informações do Perfil') }}
        </h2>
        <p>
            {{ __("Atualize as informações do perfil da sua conta, endereço de e-mail e tipo de usuário.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Nome -->
        <div class="form-group">
            <label for="name">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name" placeholder="Nome" />
            <x-input-error class="error-message" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="username" />
            <x-input-error class="error-message" :messages="$errors->get('email')" />
        </div>

        <!-- Inputs para Token e Type em colunas -->
        <div class="form-group">
            <label for="token">{{ __('Token para Mudança de Tipo') }}</label>
            <input id="token" name="token" type="text" required autocomplete="off" />
            <x-input-error class="error-message" :messages="$errors->get('token')" />
        </div>

        <div class="form-group">
            <label for="type">{{ __('Tipo') }}</label>
                <input id="type" type="text" value="{{ old('type', auth()->user()->type) }}" required readonly/>
            <x-input-error class="error-message" :messages="$errors->get('type')" />
        </div>

        @if (auth()->user()->type === 'Technician')
            <div class="form-group">
                <label for="type">{{ __('Especialidade') }}</label>
            <input id="specialty" type="text" value="{{ old('specialty', auth()->user()->technician->specialty) }}" readonly/>
            <x-input-error class="error-message" :messages="$errors->get('type')" />
        </div>
        @endif

        <!-- Botão de salvar -->
        <div class="button-container">
            <button type="submit" class="primary-button">{{ __('Salvar') }}</button>

            @if (session('status') === 'type-updated')
                <p class="status-message">{{ __('Tipo atualizado.') }}</p>
            @endif
        </div>
    </form>
</div>
</body>
</html>


<script>
    $(document).ready(function() {
        $('#type').change(function() {
            var selectedType = $(this).val();

            // Make an AJAX request to fetch the request-token partial
            $.ajax({
                url: '{{ route("profile.request-token") }}', // Define the route to fetch the partial
                method: 'GET',
                data: { type: selectedType },
                success: function(response) {
                    $('#request-token-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading request token:', error);
                }
            });
        });
    });
</script>
