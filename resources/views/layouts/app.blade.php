<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    
    <title>
        @yield('title', config('sistema.site_title'))
    </title>

    @yield('head')
  </head>
  <body @yield('body_class')>
    @yield('body_content')
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @yield('js')
  </body>
</html>
