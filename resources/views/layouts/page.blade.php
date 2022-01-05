@extends('layouts.app')

@section('head_content')
@yield('head')
@endsection

@section('body_content')
<div class="container-fluid">
    @include('layouts.includes.cabecalho')
    <div class="w-100">
        @hasSection ('title_header')
            <h5 class="my-1 text-center">@yield('title_header')</h5>
        @endif
    </div>
    @yield('content')
</div>
@endsection

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@yield('scripts')

@endsection
