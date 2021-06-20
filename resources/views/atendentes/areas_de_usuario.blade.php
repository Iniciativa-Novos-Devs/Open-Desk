@extends('layouts.page')

@section('content')
    <div class="w-100">
        <div class="col-12">
            <form method="POST" action="{{ route('atendentes.usuario.add_area', $usuario->id) }}" class="row g-3 w-100">
                @csrf
                <div class="col-12 d-none">
                    <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                </div>

                <div class="col-md-6">
                    <label for="add_area" class="form-label w-100">
                        Adicionar área ao usuário
                        <select name="area_id" id="add_area" class="form-control form-select" required>
                            <option value="">Selecione uma nova área</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nome .' - '. $area->sigla }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="pt-4 col-md-6">
                    <button class="btn btn-md btn-primary">
                        Cadastrar área para o usuário {{ $usuario->name }}
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
                                <th scope="col">Área</th>
                                <th scope="col">Sigla</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuario->areas as $area)
                                <tr>
                                    <td>{{ $area->nome }}</td>
                                    <td>{{ $area->sigla }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">
                                            Remover Área [TODO]
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
