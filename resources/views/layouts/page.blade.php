@extends('layouts.app')

@section('head')
@yield('head')
@livewireStyles
@endsection

@section('js')
@livewireScripts
@yield('js')
@endsection

@section('body_content')
<div class="container-fluid">
    @include('layouts.includes.cabecalho')
    @yield('content')
</div>
@endsection