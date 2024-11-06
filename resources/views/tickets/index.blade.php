<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/usertickets.css">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">


    <!-- Scripts -->
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    <title>QuickFix</title>
</head>

<body>
@include('layouts.quick-fix-nav')

<header>
    <main>
        <h1>{{__('Lista de Tickets')}}</h1>
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
                        @foreach(['' => 'Todos os Tickets', 'pending_approval' => 'Pendentes', 'open' => 'Abertos', 'in_progress' => 'Em Curso', 'closed' => 'Fechados'] as $value => $label)
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
        </div>
        <div>
            {{ $tickets->links() }}
        </div>

    </div>
</section>

<div>

</div>

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
