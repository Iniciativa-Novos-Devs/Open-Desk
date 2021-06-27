@extends('layouts.page')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('chamados_add') }}">Adicionar chamado</a>
    </div>

    <div class="col-12">
        @livewire('chamado-list', ['items_by_page' => 20,])
    </div>
</div>
@endsection
