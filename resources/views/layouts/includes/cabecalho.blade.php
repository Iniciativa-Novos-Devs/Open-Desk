<header>
    @include('layouts.includes.navbar_admin')

    <div class="row top-logo">
        <div class="p-0 col-2 logo-container">
            <a href="#!">
                <img class="display-2 img-fluid Responsive" src=" {{ asset('/imagens/logo.webp') }}" alt="Logo" />
            </a>
        </div>

        <div class="col d-flex align-self-center">
            <h4 class="lead">{{ config('app.name') }}</h4>
        </div>
    </div>

    <hr class="my-0">
</header>

<div class="w-100">
    <x-flash-messages />
</div>
