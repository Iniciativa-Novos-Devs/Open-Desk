<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    <!-- toastr css (https://codeseven.github.io/toastr) -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">

    {{-- Aqui está carregando o material design bootstrap --}}
    <link rel="stylesheet" href="{{ asset('css/mdb-build/app.css') }}">

    <script src="{{ asset('assets/js/auto_load_script.js') }}"></script>
    <script async src="{{ asset('js/app.js') }}"></script>
    <script async src="{{ asset('assets/js/all.js') }}"></script>

    <script>
        if(typeof window.__show_logs == 'undefined')
            window.__show_logs = {{ env('APP_DEBUG', false) }};

        function toggleShowLogs()
        {
            window.__show_logs = (typeof window.__show_logs == 'undefined') || window.__show_logs ? false : true;

            console.log("Logs: " + (window.__show_logs ? true : false));
        }

    </script>

    <title>
        <x-title value="" />
    </title>

    @hasSection ('no_livewire')

    @else
        @livewireStyles
        {{-- @powerGridStyles --}}
    @endif

    @yield('head_content')
</head>

<body @yield('body_class')>
    @yield('body_content')
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <script>

        function toastMessage(message, toast_type = 'success', options = {})
        {
            if(!window.toastr)
                return;

            var accepted_types = [
                'success',
                'info',
                'warning',
                'error',
            ];

            options     = typeof options == "object" ? options : {};
            toast_type  = accepted_types.indexOf(toast_type) !== -1 ? toast_type : 'success';

            var new_options = Object.assign(toastr.options, options)
            window.toastr.options = new_options;
            window.toastr[toast_type](message);
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            console.log('load');
            // Script in component's blade file

            if(window.Livewire)
            {
                Livewire.on('newToastMessage', e => {
                    var new_options = Object.assign(toastr.options, e.options)
                    window.toastr.options = new_options;
                    if(window.toastMessage)
                        toastMessage(e.message, e.toast_type, new_options)
                });
            }
        });
    </script>
    @yield('js')

    @hasSection ('no_livewire')

    @else
        @livewireScripts
        {{-- @powerGridScripts --}}
    @endif
</body>

</html>
