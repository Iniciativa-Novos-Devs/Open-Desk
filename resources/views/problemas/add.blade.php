@extends('layouts.page')

@section('content')

    <div class="row">
        <form action="{{ route('problemas_store') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="seletor_atividade" class="w-100"> Filtrar por Atividade
                    <select class="form-select" aria-label="Selecione uma Atividade" id='seletor_atividade' name='atividade_id' required>
                        <option value=''>Selecione uma Atividade</option>
                        @foreach ( $atividades as $atividade )
                        <option value="{{ $atividade->id }}" {{ $atividade_id == $atividade->id ? 'selected' : '' }}>
                            {{ $atividade->nome }}
                        </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="col-12">
                <label for="descricao_problema" class="w-100"> Nome do Problema
                    <input type="text" class="form-control" name="descricao" id='descricao_problema' required>
                </label>
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-success" type="submit">Cadastrar</button>
            </div>
        </form>
    </div>

@endsection
