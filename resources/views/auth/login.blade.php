@extends('layouts.basic')


{{-- Remove o livewire do componente --}}
@section('no_livewire', true)

@section('content')

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>

    <div class="pt-3 row d-flex justify-content-center">
        <div class="pt-3 mt-3 text-center col-3">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <img class="mb-4 display-6" class="Responsive" src=" {{ asset('/imagens/logo.jpg') }}" alt="logo" width="72">
                <h1 class="mb-3 h3 fw-normal">{{ __('Please sign in') }}</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="input_email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                    <label for="input_email">{{ __('E-mail') }}</label>
                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" id="input_password" name="password" placeholder="name@example.com" value="" required autocomplete="current-password">
                    <label for="input_password">{{ __('Password') }}</label>
                </div>

                <!-- Remember Me -->
                <div class="my-2 checkbox">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <button class="w-100 btn btn-lg btn-primary" type="submit">
                    {{ __('Login') }}
                </button>

                <div class="my-3">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <p class="mt-5 mb-3 text-muted">&copy; {{ date('Y') }}</p>
            </form>
        </div>
    </div>
@endsection
