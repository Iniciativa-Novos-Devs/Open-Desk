
@hasSection ('title')
    {{ env('APP_NAME') }} - @yield('title', config('sistema.site_title'))
@else
    {{ env('APP_NAME') }}
@endif
