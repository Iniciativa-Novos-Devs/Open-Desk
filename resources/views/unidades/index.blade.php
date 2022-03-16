@extends('layouts.page')


@section('title', 'Unidades')
@section('title_header', 'Unidades')

@section('content')
<div class="w-100">
    <a class="btn btn-sm btn-success"
    href="{{ route('unidades.create') }}">
    Adicionar
    </a>
</div>

<div class="w-100">
    <table class="table">
        <thead>
            <tr>
                <td colspan="100%">
                    <div class="w-100">
                        {{ $unidades->links("pagination::bootstrap-4") }}
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="col" class="cursor-pointer">#</th>
                <th scope="col" class="cursor-pointer">UE</th>
                <th scope="col" class="cursor-pointer">Nome</th>
                <th scope="col" class="cursor-pointer">Cidade</th>
                <th scope="col" class="cursor-pointer">Diretor</th>
                <th scope="col" class="cursor-pointer">Diretor ADM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unidades as $unidade)
                <tr>
                    <td>{{ $unidade->id }}</td>
                    <td>{{ $unidade->ue }}</td>
                    <td>{{ $unidade->nome }}</td>
                    <td>{{ $unidade->cidade }}</td>
                    <td>{{ $unidade->diretor }}</td>
                    <td>{{ $unidade->dir_adm }}</td>
                    <td>
                        <div class="button-group">
                            <a class="btn btn-sm btn-outline-info"
                            href="{{ route('unidades.show', $unidade->id ) }}">
                            Mais
                            </a>
                            <a class="btn btn-sm btn-primary"
                            href="{{ route('unidades.edit', $unidade->id ) }}">
                            Editar
                            </a>
                            <a class="btn btn-sm btn-danger"
                            href="{{ route('unidades.delete', $unidade->id ) }}">
                            Deletar
                            </a>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="100%">
                    <div class="w-100">
                        {{ $unidades->links("pagination::bootstrap-4") }}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
