@extends('layouts.page')

@php
    $edit   = !! ($unidade->id ?? null);
    $action = $edit ? route('unidades.update', $unidade->id) : route('unidades.store');
@endphp

@section('title', 'Unidades')
@section('title_header', 'Unidades')

@section('content')
<div class="row">
    <div class="col-12">
        <h1> {{ $edit ? "Editar" : "Criar" }} unidade</h1>
    </div>

    <div class="col-12">
        <form action="{{ $action }}" method="POST">
            @csrf

            @if ($edit)
                @method("PUT")
            @endif


            <div class="mb-3">
                <input type="text" name="ue"
                    value="{{ old("ue") ?? $unidade->ue ?? null }}"
                    placeholder="UE*" class="form-control" minlength="3" maxlength="3"
                    {{ $edit ? "disabled readonly" : "required" }}>
            </div>

            <div class="mb-3">
                <input type="text" name="nome"
                    value="{{ old("nome") ?? $unidade->nome ?? null }}"
                    placeholder="Nome*"    class="form-control" minlength="10" maxlength="150" required>
            </div>

            <div class="mb-3">
                <input type="text" name="cidade"
                    value="{{ old("cidade") ?? $unidade->cidade ?? null }}"
                    placeholder="Cidade"  class="form-control" minlength="3" maxlength="100">
            </div>

            <div class="mb-3">
                <input type="text" name="diretor"
                    value="{{ old("diretor") ?? $unidade->diretor ?? null }}"
                    placeholder="Diretor" class="form-control">
            </div>

            <div class="mb-3">
                <input type="text" name="dir_adm"
                    value="{{ old("dir_adm") ?? $unidade->dir_adm ?? null }}"
                    placeholder="Diretor administrativo" class="form-control">
            </div>

            <div class="mb-3">
                <button class="btn btn-success">{{ $edit ? "Atualizar" : "Criar" }}</button>
            </div>

        </form>
    </div>
</div>

@endsection
