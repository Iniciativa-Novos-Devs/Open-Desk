@extends('layouts.page')

@section('title_header', __('List of :items', ['items' => 'tickets']))

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('chamados_add') }}">Adicionar chamado</a>
    </div>

    <div class="col-12">
        @livewire('chamado-list', ['items_by_page' => 20, 'apenas_chamados_do_usuario' => true])
    </div>
</div>
@endsection
