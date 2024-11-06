<nav id="sidebar">
    <div id="sidebar_content">
        <div class="Avatar">
            <img src="{{ asset('administrator.png') }}" width="60"  id="imagemavatar" alt="Avatar">
            <span class="item-description">
                    <br>
                    @Username
                </span>
        </div>

        <ul id="side_items">
            <li class="side-item"><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i>
                    <span class="item-description">Perfil</span></a></li>
            <li class="side-item"><a href="{{ route('malfunctions.index') }}"><i class="fa-solid fa-file"></i>
                    <span class="item-description">Relatórios</span></a></li>
            <li class="side-item"><a href="{{ route('technicians.index') }}"><i class="fa-solid fa-users"></i>
                    <span class="item-description">Técnicos</span></a></li>


            <li class="side-item">
                <a href="">
                    <i class="fa-solid fa-desktop"></i>
                    <span class="item-description">Equipamentos</span>
                </a>
            </li>

            <li class="side-item">
                <a href="">
                    <i class="fa-solid fa-bell"></i>
                    <span class="item-description">Requests</span>
                </a>
            </li>

            <li class="side-item">
                <a href="#" id="menu-toggle">
                    <i class="fa-solid fa-list"></i>
                    <span class="item-description">Tickets <i class="fa-solid fa-caret-down" id="arrow-icon"></i></span>
                </a>
            </li>

            <li class="side-item">
                <a href="">
                    <i class="fa-solid fa-receipt"></i>
                    <span class="item-description">Registar Tickets</span>
                </a>
            </li>

            <li class="side-item">
                <a href="">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span class="item-description">Lista Status</span>
                </a>
            </li>
        </ul>

        <button id="open_btn">
            <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <div id="logout">
        <a href="">
            <button id="logout_btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="item-description">Logout</span>
            </button>
        </a>
    </div>
</nav>
<script src="{{ asset('Javascript/script.js') }}"></script>

