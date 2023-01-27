@extends('layouts.app')

{{-- Remove o livewire do componente --}}
@section('no_livewire', true)

@section('head_content')
@yield('head')
@endsection


@section('body_content')

<div class="w-100">
    <x-flash-messages/>
</div>

<div class="container-fluid px-md-4" data-view="basic.blade.php">
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
