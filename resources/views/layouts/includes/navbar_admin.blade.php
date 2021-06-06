{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HelpDesk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Principal</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Chamados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('chamados_add') }}">Abrir Chamado</a></li>
                        <li><a class="dropdown-item" href="{{ route('chamados_index') }}">Listar chamados</a></li>
                        <li><a class="dropdown-item" href="#">Atender chamados</a></li>
                    </ul>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Manutenção
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Parametros</a></li>
                        <li><a class="dropdown-item" href="#">Unidades</a></li>
                        <li><a class="dropdown-item" href="#">Usuários</a></li>
                        <li><a class="dropdown-item" href="{{ route('areas_index') }}">Áreas</a></li>
                        <li><a class="dropdown-item" href="{{ route('atividades_index') }}">Atividades</a></li>
                        <li><a class="dropdown-item" href="{{ route('problemas_index') }}">Problemas</a></li>
                        <li><a class="dropdown-item" href="#">Atendentes</a></li>
                        <li><a class="dropdown-item" href="#">Visualizar chamado</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar w/ text</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Principal</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Chamados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('chamados_add') }}">Abrir Chamado</a></li>
                        <li><a class="dropdown-item" href="{{ route('chamados_index') }}">Listar chamados</a></li>
                        <li><a class="dropdown-item" href="#">Atender chamados</a></li>
                    </ul>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Manutenção
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Parametros</a></li>
                        <li><a class="dropdown-item" href="#">Unidades</a></li>
                        <li><a class="dropdown-item" href="#">Usuários</a></li>
                        <li><a class="dropdown-item" href="{{ route('areas_index') }}">Áreas</a></li>
                        <li><a class="dropdown-item" href="{{ route('atividades_index') }}">Atividades</a></li>
                        <li><a class="dropdown-item" href="{{ route('problemas_index') }}">Problemas</a></li>
                        <li><a class="dropdown-item" href="#">Atendentes</a></li>
                        <li><a class="dropdown-item" href="#">Visualizar chamado</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#profile">
                                    {{ __('Profile') }}
                                    <i class="bi bi-person-badge-fill"></i>
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">
                                    {{ __('Logout') }}
                                    <i class="bi bi-box-arrow-left"></i>
                                </a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                {{ __('Login') }}
                                <i class="bi bi-key-fill"></i>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
