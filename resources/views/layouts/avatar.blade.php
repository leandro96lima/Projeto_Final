<div class="Avatar">
    <img src="{{ asset(Auth::user()->getType() === 'Admin' ? 'administrator.png' :
 (Auth::user()->getType() === 'Technician' ? 'technician.png' : 'hacker.png')) }}" width="60" id="imagemavatar" alt="Avatar">
    <span class="item-description">
        <br>
        {{ __(Auth::user()->name) }}
    </span>
</div>
