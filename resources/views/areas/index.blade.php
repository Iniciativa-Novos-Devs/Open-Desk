@extends('layouts.page')


@section('title', 'Áreas')
@section('title_header', 'Áreas')

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
            @foreach ($areas as $area)
                <tr>
                    <td>{{ $area->id }}</td>
                    <td>{{ $area->nome }}</td>
                    <td>{{ $area->sigla }}</td>
                    <td>
                        <a class="btn btn-sm btn-outline-info"
                        href="{{ route('areas_show', [$area->id, \Str::slug($area->sigla.'-'.$area->nome)]) }}">
                        Mais
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
