@extends('layouts.app')

@section('head_content')
@yield('head')
@endsection


@section('body_content')

<div class="w-100">
    <x-flash-messages/>
</div>

<div class="container-fluid">
    @hasSection ('content')
        @yield('content')
    @else
        {{ $slot }}
    @endif
</div>

@endsection

@section('js')
@yield('scripts')
@endsection
