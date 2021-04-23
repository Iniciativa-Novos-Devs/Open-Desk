@extends('layouts.app')

@section('head_content')
@yield('head')
@livewireStyles
@endsection


@section('body_content')
<div class="container-fluid">
@include('layouts.includes.cabecalho')
@yield('content')
</div>
@endsection

@section('js')
@livewireScripts
@yield('scripts')
@endsection