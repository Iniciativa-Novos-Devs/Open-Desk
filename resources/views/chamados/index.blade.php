@extends('layouts.page')

@section('content')
<div class="w-100">
    <div class="col-12">
        <a href="{{ route('chamados_add') }}">Adicionar chamado</a>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-12">
                @livewire('chamado-list', ['items_by_page' => 20,])
            </div>
        </div>
    </div>
</div>
@endsection
