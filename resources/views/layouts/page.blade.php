@extends('layouts.app')

@section('head_content')
@yield('head')
@endsection

@section('body_content')
<div class="container-fluid px-4 py-5 py-md-1" data-view="page.blade.php">
    @include('layouts.includes.cabecalho')
    @yield('content')
</div>
@endsection

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@yield('scripts')

@endsection
