@extends('layouts.page')

@php
    $edit = !! ($atividade ?? null);
    $action = $edit ? route('atividades_update', $atividade->id) : route('atividades_store');
@endphp

@section('content')

    <form action="{{ $action }}" method="POST">
        @csrf
        <fieldset>
            <legend>
                {{ $edit ? 'Editar' : 'Criar' }}  Atividade
            </legend>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da atividade</label>
                <input type="text" id="nome" name="nome" value="{{ old('nome') ?? $atividade->nome ?? null }}" class="form-control" placeholder='' _maxlength="50" >
                @error('nome')

                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ $edit ? 'Atualizar' : 'Cadastrar' }}</button>
        </fieldset>
    </form>

@endsection
