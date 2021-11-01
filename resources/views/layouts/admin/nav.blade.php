<!-- DASHBOARD MENU -->
<header>
    <div class="logo">
        <a href="/admin">
            <figure>
                <img src="{{asset('assets/admin/images/logogrupo.png')}}" alt="Logo grupo Gracom">
            </figure>
        </a>
    </div>
    <nav class="suave">
        <ul>
            <li>
                <a href="{{route('admin')}}" class="suave @if(Route::current()->getName() == 'admin')ativo @endif">Dashboard</a>
            </li>
            <li>
                <a href="{{route('gracom')}}" class="suave @if(Route::current()->getName() == 'gracom')ativo @endif">Gracom</a>
            </li>
            <li>
                <a href="{{route('imugi')}}" class="suave @if(Route::current()->getName() == 'imugi')ativo @endif">Imugi</a>
            </li>
            <li>
                <a href="#" class="suave @if(Route::current()->getName() == 'tiamate')ativo @endif">Tiamate</a>
            </li>
            <li>
                <a href="/admin/logout" class="suave">
                    Sair
                </a>
            </li>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
    </nav>
    <div class="perfil">
        <div class="infos">
            <h6 class="barlow">
                {{ Auth::user()->name }}
                <span>
                </span>
            </h6>
        </div>
    </div>
    <div class="clear"></div>
</header>
<!-- /DASHBOARD MENU -->