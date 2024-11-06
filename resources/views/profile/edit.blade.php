<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/userpage.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">





    <title>QuickFix</title>
</head>

<body>

@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>Perfil do Utilizador</h1>
    </main>
</header>


<div class="container">
    <div class="wrapper">
        <div class="insidecontainer" style="width: 50%">
            <div class="card">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="card2">
                @include('profile.partials.update-password-form')
            </div>
            <div class="card2">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
        <div class="insidecontainer" style="width: 30%" >
            <!-- Segunda coluna: Solicitar Token ao Administrador -->
            @include("profile.partials.request-token")
        </div>
    </div>
</div>


