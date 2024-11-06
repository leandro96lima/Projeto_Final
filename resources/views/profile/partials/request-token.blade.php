<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Token</title>
    <style>


        header {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.125rem; /* text-lg */
            font-weight: 500; /* font-medium */
            color: #1F2937; /* text-gray-900 */
        }

        p {
            margin-top: 0.25rem; /* mt-1 */
            font-size: 0.875rem; /* text-sm */
            color: #4B5563; /* text-gray-600 */
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #1F2937;
        }

        select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #D1D5DB;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .status-message {
            color: #4B5563; /* text-gray-600 */
            font-size: 14px;
        }
    </style>
</head>
<body>
        <header>
            <h2>{{ __('Solicitar Token') }}</h2>
            <p>{{ __('Se você precisa de um token para mudar seu tipo de usuário, solicite a um administrador.') }}</p>
            <p>{{ __('Por favor, verifique seu e-mail nas próximas 24 horas.') }}</p>
        </header>

        <form method="post" action="{{ route('profile.request-token') }}">
            @csrf

            <div class="form-group">
                <label for="requested_type">{{ __('Tipo Solicitado') }}</label>
                <select id="requested_type" name="requested_type">
                    <option value="User"> User</option>
                    <option value="Admin"> Admin</option>
                    <option value="Technician"> Technician</option>
                </select>
                <div class="error-message">@if ($errors->has('requested_type')) {{ $errors->first('requested_type') }} @endif</div>
            </div>

            <div class="form-group">
                <label for="request_reason">{{ __('Razão da Solicitação') }}</label>
                <textarea id="request_reason" name="request_reason" rows="3" required></textarea>
                <div class="error-message">@if ($errors->has('request_reason')) {{ $errors->first('request_reason') }} @endif</div>
            </div>

            <div class="button-container">
                <button class="primary-button"type="submit">{{ __('Solicitar Token') }}</button>

                @if (session('status') === 'token-requested')
                    <p class="status-message">{{ __('Solicitação de token enviada.') }}</p>
                @endif
            </div>
        </form>
</body>
</html>
