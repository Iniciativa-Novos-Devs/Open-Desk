<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top py-1 py-md-3">
    <div class="container-fluid">
        <div class="w-100 d-flex justify-content-center text-center mb-2">
                <a class="p-0 col-2 logo-container d-flex justify-content-around navbar-brand" href="{{ route('painel') }}">
                    <img class="display-2 img-fluid Responsive mx-2" src=" {{ asset('/imagens/logo.webp') }}" alt="Logo" />
                    {{ config('app.name', 'Open Desk') }}
                </a>
        </div>

        <div class=" w-100 d-flex justify-content-between">
            @auth
            @can('chamados-create')
                <div class="d-none d-md-block d-xl-none"></div>
                <div class="d-md-none tf-vertical-align">
                    <a class="btn btn-sm btn-warning" href="{{ route('chamados_add') }}">Abrir Chamado</a>
                </div>
                @endcan
            @endauth

            <div>
                <button class="navbar-toggler tf-toggler-small" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="mb-2 navbar-nav me-auto mb-lg-0 mx-md-4">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="@route('dashboard')">Dashboard</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="chamadoNavbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Chamados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="chamadoNavbarDropdownMenuLink">
                        @can('chamados-create')
                            <li><a class="dropdown-item" href="{{ route('chamados_add') }}">Abrir Chamado</a></li>
                        @endcan

                        @can('chamados-read')
                            <li><a class="dropdown-item" href="{{ route('chamados_index') }}">Meus chamados</a></li>
                            <li><a class="dropdown-item" href="{{ route('homologacao_index') }}">Homologação de chamados</a></li>
                        @endcan

                        @can('chamados-atender')
                            <li><a class="dropdown-item" href="{{ route('atendimentos_index') }}#detalhes_do_chamado">Atender chamados</a></li>
                        @endcan
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="@route('chamados_add')">
                        Abrir Chamado
                    </a>
                </li>

                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminNavbarDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Manutenção
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminNavbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('unidades.index') }}">Unidades</a></li>
                        @canany(['usuarios-all', 'usuarios-create', 'usuarios-read', 'usuarios-update', 'usuarios-delete'])
                            <li><a class="dropdown-item" href="@route('usuarios.index')">@lang('Users')</a></li>
                        @endcanany
                        @canany(['roles-all', 'roles-create', 'roles-read', 'roles-update', 'roles-delete'])
                            <li><a class="dropdown-item" href="@route('roles.index')">@lang('Roles')</a></li>
                        @endcanany
                        <li><a class="dropdown-item" href="{{ route('areas_index') }}">Áreas</a></li>
                        <li><a class="dropdown-item" href="{{ route('atividades_index') }}">Atividades</a></li>
                        <li><a class="dropdown-item" href="{{ route('problemas_index') }}">Problemas</a></li>
                        <li><a class="dropdown-item" href="{{ route('atendentes.index') }}">Atendentes</a></li>
                    </ul>
                </li>
                @endrole

                @endauth
                @auth
                    @can('chamados-create')
                        <li class="nav-item d-none d-sm-none d-md-block d-lg-block">
                            <a class="btn btn-warning nav-link" href="{{ route('chamados_add') }}">Abrir Chamado</a>
                        </li>
                    @endcan
                @endauth
            </ul>
            <div class="order-3 navbar-collapse collapse w-100 dual-collapse2">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                    href="#"
                                    id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                >
                                <i class="bi bi-person-circle"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.preferences') }}">
                                        <i class="bi bi-person-badge-fill"></i>
                                        {{ __('Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="bi bi-box-arrow-left"></i>
                                        {{ __('Logout') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-key-fill"></i>
                                {{ __('Login') }}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
