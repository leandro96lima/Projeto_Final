<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/usertickets.css">
    <link rel="shortcut icon" href="imagens/icons8-repair-96.png" type="image/x-icon">
    <title>QuickFix</title>
</head>

<body>
<nav id="sidebar">
    <div id="sidebar_content">
        <div class="Avatar">
            <img src="/imagens/hacker.png" width="60" id="imagemavatar" alt="Avatar">
            <span class="item-description">
                    <br>
                    @Utilizador
                </span>
        </div>
        <ul id="side_items">
            <li class="side-item"><a href="userpage.html"><i class="fa-solid fa-user"></i> <span class="item-description">Perfil</span></a></li>
            <li class="side-item"><a href="ticket.html"><i class="fa-solid fa-receipt"></i> <span class="item-description">Registar Tickets</span></a></li>
            <li class="side-item"><a href="usertickets.html"><i class="fa-solid fa-list"></i> <span class="item-description">Tickets</span></a></li>
        </ul>
        <button id="open_btn"><i id="open_btn_icon" class="fa-solid fa-chevron-right"></i></button>
    </div>
    <div id="logout">
        <a href="login2.html"><button id="logout_btn"><i class="fa-solid fa-right-from-bracket"></i> <span class="item-description">Logout</span></button></a>
    </div>
</nav>

<header>
    <main>
        <h1>Lista de Tickets</h1>
    </main>
</header>
<section class="container">
    <div class="insidecontainer">
        <div class="pesquisa-ordenar">
            <div class="search-box">
                <form action="{{ route('tickets.index') }}" method="GET">
                    <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
                    <input type="search" name="search" class="input-search" placeholder="Pesquisar" aria-label="Search">
                </form>
            </div>
            <div>
                <form method="GET" action="{{ route('tickets.index') }}">
                    <select name="status" class="dropdown2" onchange="this.form.submit()">
                        <option value="" disabled selected hidden>Filtrar por Status:</option>
                        @foreach(['pending_approval' => 'Pendentes', 'open' => 'Abertos', 'in_progress' => 'Em Curso', 'closed' => 'Fechados'] as $value => $label)
                            <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ __($label) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="insidecontainer1">
            <table>
                <thead>
                <tr>
                    <th><button class="order">Equipamento</button></th>
                    <th><button class="order">Avaria</button></th>
                    <th><button class="order">Data de Abertura</button></th>
                    <th><button class="order">Status</button></th>
                    <th><button class="order">Tempo de Espera</button></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->malfunction ? $ticket->malfunction->equipment->type : 'N/A' }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->open_date }}</td>
                        <td>{{ $ticket->status ?? 'N/A' }}</td>
                        <td>{{ $ticket->wait_time !== null ? $ticket->wait_time : 'Em espera para iniciar' }} minuto(s)</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</section>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif
    }

    body {
        display: flex;
        min-height: 100vh;
        background-color: #99A3B9;
    }


    main {
        display: flex;
        margin-top: 10px;
        margin-left: 20px;
        padding: 20px;
        position: fixed;
        width: 93.5%;
        z-index: 1;
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);


    }

    #sidebar {
        margin-top: 10px;
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #ffffff;
        border-radius: 0px 18px 18px 0px;
        position: relative;
        transition: all .5s;
        min-width: 82px;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);

    }

    #sidebar_content {
        padding: 12px;
    }

    #user {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    #user_avatar {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 20px;
    }

    #user_infos {
        display: flex;
        flex-direction: column;
    }

    #user_infos span:last-child {
        color: #6b6b6b;
        font-size: 12px;
    }

    #side_items {
        display: flex;
        flex-direction: column;
        gap: 8px;
        list-style: none;

    }

    .side-item {
        border-radius: 8px;
        padding: 14px;
        cursor: pointer;


    }

    .side-item.active {
        background-color: #0077ff;
    }

    .side-item:hover:not(.active),
    #logout_btn:hover {
        background-color: #e3e9f7;
    }

    .side-item a {
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0a0a0a;
    }

    .side-item.active a {
        color: #e3e9f7;
    }

    .side-item a i {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
    }

    #logout {
        border-top: 1px solid #e3e9f7;
        padding: 12px;
    }

    #logout_btn {
        border: none;
        padding: 12px;
        font-size: 14px;
        display: flex;
        gap: 20px;
        align-items: center;
        border-radius: 8px;
        text-align: start;
        cursor: pointer;
        background-color: transparent;
    }

    #open_btn {
        position: absolute;
        top: 30px;
        right: -10px;
        background-color: #0077ff;
        color: #e3e9f7;
        border-radius: 100%;
        width: 20px;
        height: 20px;
        border: none;
        cursor: pointer;
    }

    #open_btn_icon {
        transition: transform .3s ease;
    }

    .open-sidebar #open_btn_icon {
        transform: rotate(180deg);
    }

    .item-description {
        width: 0px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 14px;
        transition: width .6s;
        height: 0px;
    }

    #sidebar.open-sidebar {
        min-width: 15%;
    }

    #sidebar.open-sidebar .item-description {
        width: 100px;
        height: auto;
    }

    #sidebar.open-sidebar .side-item a {
        justify-content: flex-start;
        gap: 14px;
    }

    /* -------------------CARDS--------------------------------- */

    .container {
        display: flex;
        /* Use Flexbox to center the carousel */
        justify-content: flex-start;
        /* Center horizontally */
        align-items: flex-start;
        /* Center vertically */
        flex-direction: row;
        /* Stack items vertically if needed */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);

        width: 100%;
        margin: 100px 20px 10px;
        /* Simplified margin */
        background-color: #ffffff;
        border-radius: 18px;
    }


    .insidecontainer {
        display: flex;
        width: 100%;
        align-items: flex-start;
        flex-direction: column;
        justify-content: space-between;
        margin: 20px;
        /* Se necessário, mantenha, mas ajuste conforme necessário */
    }

    .insidecontainer1 {
        display: flex;
        width: 100%;
        align-items: flex-start;
        flex-direction: column-reverse;
        justify-content: space-between;

    }



    .botao {
        width: 200px;
        margin: 5px;
        border-radius: 20px;
        border: 1px solid #777777;
        background-color: #777777;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        text-align: center;
    }

    .botao:hover {
        background-color: #777777;
        /* Darken the background on hover */

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Enhance shadow on hover */


    }

    .botao:active {
        transform: scale(0.95);
    }

    a {
        outline: none;
        /* Remove o contorno padrão */
        text-decoration: none;
        /* Remove o sublinhado, se desejado */
        color: white;
    }

    a:focus {
        outline: none;
        /* Remove o contorno quando o link está em foco */
    }

    .botao2 {
        width: 200px;
        margin: 5px;
        border-radius: 20px;
        border: 1px solid #c90505;
        background-color: #c90505;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        text-align: center;
    }

    .botao2:hover {
        background-color: #c90505;
        /* Darken the background on hover */

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Enhance shadow on hover */


    }

    .botao:active {
        transform: scale(0.95);
    }

    a {
        outline: none;
        /* Remove o contorno padrão */
        text-decoration: none;
        /* Remove o sublinhado, se desejado */
        color: white;
    }

    a:focus {
        outline: none;
        /* Remove o contorno quando o link está em foco */
    }





    .botao3 {
        width: 50px;
        margin: 5px;
        border-radius: 10px;
        border: 1px solid #0077ff;
        background-color: #0077ff;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        text-align: center;
    }

    .botao3:hover {
        background-color: #0077ff;
        /* Darken the background on hover */

        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        /* Enhance shadow on hover */


    }

    .botao3:active {
        transform: scale(0.95);
    }

    .botao3 i {


        font-size: 15px;

    }

    a {
        outline: none;
        /* Remove o contorno padrão */
        text-decoration: none;
        /* Remove o sublinhado, se desejado */
        color: white;
    }

    a:focus {
        outline: none;
        /* Remove o contorno quando o link está em foco */
    }





    input {

        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 30px;
    }

    select {
        margin: 5px;
        padding: 5px;
        /* Padding for better appearance */
        border: 1px solid #ccc;
        /* Border styling */
        border-radius: 5px;
        /* Rounded corners */
        font-size: 16px;
        /* Font size */
        background-color: #f9f9f9;
        /* Background color */
        cursor: pointer;
        /* Pointer cursor on hover */
    }

    select:focus {
        outline: none;
        /* Remove default focus outline */
        border-color: #007bff;
        /* Change border color on focus */
    }


    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin: 20px 0;
    }

    th, td {

        padding: 12px 15px;
        text-align: left;
        font-size: 14px;

        font-weight: normal; /* Ensure text weight consistency */
    }

    th {
        background-color: #99a3b9;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #99a3b9;
        color: white;
    }






    .descricao {
        text-align: left;
        width: 30%;
        /* Aumenta o espaço para Descrição e Diagnóstico */
    }


    #displaybotao {


        display: flex;
        justify-content: center;

    }

    .add{

        margin-top: 15px;



    }


    .Avatar{

        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: center;
        margin-bottom: 20px;

    }

    #imagemavatar{

        border: 2px solid black;
        border-radius: 80%;
    }



    /* SEARCH BAR */

    .search-box {
        width: fit-content;
        height: fit-content;
        position: relative;
    }

    .input-search {

        width: 50px;
        border-style: none;
        padding: 10px;
        font-size: 18px;
        letter-spacing: 2px;
        outline: none;
        border-radius: 25px;
        transition: all .5s ease-in-out;

        padding-right: 40px;
        color: #000000;
    }

    .input-search::placeholder {
        color: #000000;
        font-size: 18px;
        letter-spacing: 2px;
        font-weight: 80px;
    }

    .btn-search {
        width: 50px;
        height: 50px;
        border-style: none;
        font-size: 20px;
        font-weight: bold;
        outline: none;
        cursor: pointer;
        border-radius: 50%;
        position: absolute;
        right: 0px;
        color: #0077ff;
        background-color: transparent;
        pointer-events: painted;
    }

    .btn-search:focus~.input-search {
        width: 300px;
        border-radius: 0px;
        background-color: transparent;
        border-bottom: 1px solid #99A3B9;
        transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
    }

    .input-search:focus {
        width: 300px;
        border-radius: 0px;
        background-color: transparent;
        border-bottom: 1px solid #0077ff;
        transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
    }

    .pesquisa-ordenar {
        display: flex;
        justify-content: space-between; /* Ensures space between search box and dropdown */
        align-items: center; /* Aligns items vertically */
        width: 100%; /* Ensures the full width is used */

    }

    .dropdown2 {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #ffffff;
    }

    .order{

        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font: inherit;
        padding: 0;
        margin: 0;
        font-size: larger;

    }
</style>

<script>
    document.getElementById('open_btn').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const dropdowns = document.querySelectorAll('.dropdown');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle sidebar visibility
        sidebar.classList.toggle('open-sidebar');

        // Close all dropdowns
        dropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });

        // Reset arrow icon if sidebar is closing
        if (!sidebar.classList.contains('open-sidebar')) {
            arrowIcon.style.transform = 'rotate(0deg)';
        }
    });

    // --------------------------------------------

    const sideItems = document.querySelectorAll('.side-item');

    sideItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove 'active' class from all side items
            sideItems.forEach(sideItem => {
                sideItem.classList.remove('active');
            });

            // Add 'active' class to the clicked item
            item.classList.add('active');
        });
    });

    // ----------------------------------------------

    document.getElementById('menu-toggle').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the link
        const dropdown = this.nextElementSibling.querySelector('.dropdown');
        const arrowIcon = document.getElementById('arrow-icon');

        // Toggle dropdown visibility
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

        // Rotate the arrow icon
        if (dropdown.style.display === 'block') {
            arrowIcon.style.transform = 'rotate(180deg)';
        } else {
            arrowIcon.style.transform = 'rotate(0deg)';
        }
    });


    document.addEventListener('DOMContentLoaded', () => {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('#side_items a');

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.6 // Adjusts when the section is considered in view
        };

        const observerCallback = (entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                const navLink = document.querySelector(`#side_items a[href="#${id}"]`);

                if (entry.isIntersecting) {
                    navLink.classList.add('active');
                } else {
                    navLink.classList.remove('active');
                }
            });
        };

        const observer = new IntersectionObserver(observerCallback, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    });





</script>


</body>
</html>
