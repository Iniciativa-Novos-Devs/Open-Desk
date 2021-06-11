@extends('layouts.page')

@section('content')
    <div class="w-100">
        <div class="col-12">
            <form method="POST" action="{{ route('add_atividade_ao_usuario', $usuario->id) }}" class="row g-3 w-100">
                @csrf
                <div class="col-12 d-none">
                    <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                </div>

                <div class="col-md-6">
                    <label for="add_atividade" class="form-label w-100">
                        Adicionar atividade ao usuário
                        <select name="atividades_area_id" id="add_atividade" class="form-control form-select" required>
                            <option value="">Selecione uma nova atividade</option>
                            @foreach ($atividades as $atividade)
                                <option value="{{ $atividade->id }}">{{ $atividade->nome }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="pt-4 col-md-6">
                    <button class="btn btn-md btn-primary">
                        Cadastrar atividade para o usuário {{ $usuario->name }}
                    </button>
                </div>
            </form>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Atividade</th>
                                <th scope="col">Área</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuario->atividades as $atividade)
                                <tr>
                                    <th scope="row">{{ $atividade->id }}</th>
                                    <td>{{ $atividade->nome }}</td>
                                    <td>{{ $atividade->area->sigla .' - '.  $atividade->area->nome}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">
                                            Remover Atividade
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
