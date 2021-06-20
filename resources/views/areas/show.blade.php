@extends('layouts.page')

@section('title', 'Áreas - '. $area->nome)
@section('title_header', 'Áreas - '. $area->nome)

@section('content')
    <div class="w-100">
        <div class="col-12">
            <form method="POST" action="{{ route('atendentes.usuario.add_area') }}" class="row g-3 w-100">
                @csrf
                <div class="col-12 d-none">
                    <input type="hidden" name="area_id" value="{{ $area->id }}">
                </div>

                <div class="col-md-6">
                    <label for="add_area" class="form-label w-100">
                        Adicionar atendente à área {{ $area->name }}
                        <select name="usuario_id" id="usuario_id" class="form-control form-select" required>
                            <option value="">Selecione um atendente</option>
                            @foreach ($atendentes as $atendente)
                                <option value="{{ $atendente->id }}">{{ $atendente->name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="pt-4 col-md-6">
                    <button class="btn btn-md btn-primary">
                        Cadastrar o atendente à área
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
                                <th scope="col">Atendente</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($area->atendentes as $atendente)
                                <tr>
                                    <td>{{ $atendente->name }}</td>
                                    <td>{{ $atendente->email }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger">
                                            Remover Atendente [TODO]
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
