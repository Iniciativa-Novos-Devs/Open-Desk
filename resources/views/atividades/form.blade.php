@extends('layouts.page')

@php
$edit = !!($atividade ?? null);
$action = $edit ? route('atividades_update', $atividade->id) : route('atividades_store');
@endphp

@section('content')

    <form action="{{ $action }}" method="POST" class='row g-6'>
        @csrf
        <h6>
            {{ $edit ? 'Editar' : 'Criar' }} Atividade
        </h6>

        <div class="col-md-6">
            <label for="nome" class="form-label">Nome da atividade</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') ?? ($atividade->nome ?? null) }}"
                class="form-control" placeholder='' maxlength="50" required>
                @error('nome')

                @enderror
        </div>

        <div class="col-md-4">
            <label for="area_id" class="form-label">Selecione Area</label>
            <select id="area_id" name='area_id' class="form-select" required>
                <option value='' {{ !$area_id ? 'selected' : '' }}>Escolha um problema</option>
                @foreach ($areas as $area)
                    <option {{ $area_id == $area->id ? 'selected' : '' }} value='{{ $area->id }}'>{{ $area->sigla . ' - ' . $area->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 pt-3">
            <button type="submit" class="btn btn-primary mt-3 w-100">{{ $edit ? 'Atualizar' : 'Cadastrar' }}</button>
        </div>
    </form>

@endsection
