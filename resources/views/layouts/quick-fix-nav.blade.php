<nav id="sidebar">
    <div id="sidebar_content">
        <div class="Avatar">
            <img src="{{ asset('hacker.png') }}" width="60" id="imagemavatar" alt="Avatar">
            <span class="item-description">
                    <br>
                    @Utilizador
                </span>
        </div>
        <ul id="side_items">
            <li class="side-item"><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i> <span class="item-description">Perfil</span></a></li>
            <li class="side-item"><a href="{{ route('tickets.create') }}"><i class="fa-solid fa-receipt"></i> <span class="item-description">Registar Tickets</span></a></li>
            <li class="side-item"><a href="{{ route('tickets.index') }}"><i class="fa-solid fa-list"></i> <span class="item-description">Tickets</span></a></li>

        </ul>

        <button id="open_btn"><i id="open_btn_icon" class="fa-solid fa-chevron-right"></i></button>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" id="logout_btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="item-description">Logout</span>
        </button>
    </form>
</nav>
