@extends('layouts.page')

@section('content')
<div class="w-100">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="cursor-pointer">#</th>
                <th scope="col" class="cursor-pointer">Nome</th>
                <th scope="col" class="cursor-pointer">Sigla</th>
                <th scope="col" class="">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $area->id }}</td>
                <td>{{ $area->nome }}</td>
                <td>{{ $area->sigla }}</td>
                <td>editar</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection