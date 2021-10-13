<!-- DASHBOARD MENU -->
<header>
    <div class="logo">
        <a href="admin">
            <figure>
                <img src="{{asset('assets/admin/images/logoGrupo.png')}}" alt="Logo grupo Gracom">
            </figure>
        </a>
    </div>
    <nav class="suave">
        <ul>
            <li>
                <a href="/admin" class="suave">Dashboard</a>
            </li>
            <li>
                <a href="/gracom" class="suave">Gracom</a>
            </li>
            <li>
                <a href="/imugi" class="suave">Imugi</a>
            </li>
            <li>
                <a href="/tiamate" class="suave">Tiamate</a>
            </li>
            <li>
                <a href="/admin/logout" class="suave">
                    Sair
                </a>
            </li>
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