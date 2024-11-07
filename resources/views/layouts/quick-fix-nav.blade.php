<nav id="sidebar">
    <div id="sidebar_content">

@include('layouts.avatar')

        <ul id="side_items">

            <li class="side-item"><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user"></i>
                    <span class="item-description">{{ __('Perfil') }}</span></a></li>

            <li class="side-item"><a href="{{ route('tickets.index') }}"><i class="fa-solid fa-list"></i>
                    <span class="item-description">{{ __('Tickets') }}</span></a></li>
            @if(in_array(Auth::user()->getType(), ['User']))
                <li class="side-item"><a href="{{ route('tickets.create') }}"><i class="fa-solid fa-receipt"></i>
                        <span class="item-description">{{ __('Registar Tickets') }}</span></a></li>
            @endif
            @if(in_array(Auth::user()->getType(), ['Admin']))
                <li class="side-item"><a href="{{ route('admin.requests') }}"> <i class="fa-solid fa-bell"></i>
                        <span class="item-description">{{ __('Solicitações') }}</span></a></li>
                <li class="side-item"><a href="{{ route('equipments.index') }}"><i class="fa-solid fa-desktop"></i>
                        <span class="item-description"> {{ __('Equipamentos') }}</span></a></li>
                <li class="side-item"><a href="{{ route('malfunctions.index') }}"><i class="fa-solid fa-file"></i>
                        <span class="item-description">{{ __('Relatórios') }}</span></a></li>
                <li class="side-item"><a href="{{ route('technicians.index') }}"><i class="fa-solid fa-users"></i>
                        <span class="item-description">{{ __('Técnicos') }}</span></a></li>
            @endif
        </ul>

        <button id="open_btn">
            <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" id="logout_btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span class="item-description">{{ __('Logout') }}</span>
        </button>
    </form>
</nav>
<script src="{{ asset('Javascript/script.js') }}"></script>

