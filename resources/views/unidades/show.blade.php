@extends('layouts.page')

@section('title', 'Unidades')
@section('title_header', 'Unidades')

@section('content')
<div class="row">
    <div class="col-12">
        <h1> Unidade {{ $unidade->nome }} - ({{ $unidade->ue }})</h1>
    </div>

    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <td colspan="100%">
                        <a href="{{ route("unidades.edit", $unidade->id) }}"
                            class="btn btn-sm btn-primary">
                            Editar
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>UE</th>
                    <td>{{ $unidade->ue }}</td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td>{{ $unidade->nome }} </td>
                </tr>
                <tr>
                    <th>Cidade</th>
                    <td>{{ $unidade->cidade  }}</td>
                </tr>
                <tr>
                    <th>Diretor</th>
                    <td>{{ $unidade->diretor  }}</td>
                </tr>
                <tr>
                    <th>Diretor administrativo</th>
                    <td>{{ $unidade->dir_adm  }}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

@endsection
