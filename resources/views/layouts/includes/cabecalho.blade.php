<header>
    @include('layouts.includes.navbar_admin')

    <div class="w-100 mt-4 pt-1"></div>

    <div class="row top-logo">
        <h4 class="my-1 text-center">
            @hasSection ('title_header')
                @yield('title_header')
            @else
                @hasSection ('title')
                    @yield('title')
                @else
                {{ config('app.name') }}
                @endif
            @endif
        </h4>
    </div>
</header>

<x-flash-messages />
