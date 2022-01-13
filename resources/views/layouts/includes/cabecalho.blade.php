<header>
    <div class="row">
        <div class="p-0 col-2 logo-container">
            <a href="#!">
                <img class="display-2 img-fluid Responsive" src=" {{ asset('/imagens/logo.jpg') }}" alt="logo" />
            </a>
        </div>
        <div class="col-4 d-flex align-self-center">
            <h4 class="lead">{{ config('app.name') }}</h4>
        </div>
    </div>

    <hr class="my-0">

    @if ($admin = true)
        @include('layouts.includes.navbar_admin')
    @else
        @include('layouts.includes.navbar_user')
    @endif
</header>

<div class="w-100">
    <x-flash-messages />
</div>
