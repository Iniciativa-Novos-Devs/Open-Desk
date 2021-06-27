@extends('layouts.page')

@section('title', 'Lista de chamados')
@section('title_header', 'Lista de chamados')

@section('content')
<div class="row">
    <div class="col-12">
        @livewire('atendimentos-chamado-list', ['items_by_page' => 20,])
    </div>
</div>
@endsection
