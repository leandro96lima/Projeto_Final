<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/resquests.css') }}">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">




    <title>QuickFix</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>Solicitações</h1>

    </main>



</header>

<style>

    .content {
        margin-top: 20px;
    }

    .card {
        background-color: #ffffff; /* Cor do cartão */
        border-radius: 0.5rem; /* Bordas arredondadas */
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); /* Sombra */
        padding: 20px;
    }


    .action-form {
        display: inline-block; /* Para que os botões fiquem lado a lado */
        margin-right: 10px; /* Espaço entre os botões */
    }
</style>


<section class="container">


    <div class="content">
        <div class="card" style="width: 1400px">
            <h3 class="section-title">Alteração do Tipo de Utilizador</h3>

            <div class="insidecontainer1">
            <table class="table" >
                <thead>
                <tr>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Tipo Solicitado') }}</th>
                    <th>{{ __('Razão') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($typeChangeRequests as $request)
                    <tr>
                        <td>{{ $request->user_id }}</td>
                        <td>{{ $request->requested_type }}</td>
                        <td>{{ $request->reason }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            <form class="action-form" method="POST" action="{{ route('admin.approve-type-change-request', $request) }}">
                                @csrf
                                <button type="submit" class="botao3">Approve</button>
                            </form>
                            <form class="action-form" method="POST" action="{{ route('admin.reject-type-change-request', $request) }}">
                                @csrf
                                <button type="submit" class="botao2">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>

            <div class="insidecontainer1">
            <h3 class="section-title">Novo Equipamento</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('ID Equipmento') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($ticketApprovalRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->equipment_id }}</td>
                        <td>{{ $request->status }}</td>
                        <td>
                            <form class="action-form"  method="POST" action="{{ route('admin.approve-new-equipment-request', $request) }}">
                                @csrf
                                <button type="submit" class="botao3">Approve</button>
                            </form>
                            <form class="action-form" method="POST" action="{{ route('admin.reject-new-equipment-request', $request) }}">
                                @csrf
                                <button type="submit" class="botao2">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
</section>


<script src="{{asset('Javascript/script.js')}}"></script>

</body>

</html>
