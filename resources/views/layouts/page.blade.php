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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@yield('scripts')
@endsection
