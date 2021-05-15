<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                        <li><a class="dropdown-item" href="{{  route('problemas_index') }}">Problemas</a></li>
                        <li><a class="dropdown-item" href="#">Atendentes</a></li>
                        <li><a class="dropdown-item" href="#">Visualizar chamado</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
