@extends('layouts.page')

@section('content')
    <div class="w-100">
        <div class="col-12">
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th scope="col" class="text-left">#</th>
                                <th scope="col" class="text-center">Nome</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atendentes as $atendente)
                                <tr>
                                    <th scope="row"> {{ $atendente->id }} </th>
                                    <td>{{ $atendente->name }} | {{ $atendente->email }}</td>
                                    <td>
                                        <div class="flex-row-reverse d-flex">
                                            <div class="btn-group btn-group-sm">
                                                <div class="mx-1">
                                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('atendentes.usuario.atividades', $atendente->id) }}">
                                                        Atividades
                                                    </a>
                                                </div>
                                                <div class="mx-1">
                                                    <a class="btn btn-sm btn-outline-secondary" href="#">
                                                        xxxxx
                                                    </a>
                                                </div>
                                                <div class="mx-1">
                                                    <a class="btn btn-sm btn-outline-secondary" href="#">
                                                        xxxxx
                                                    </a>
                                                </div>
                                                <div class="mx-1">
                                                    <a class="btn btn-sm btn-outline-secondary" href="#">
                                                        xxxxx
                                                    </a>
                                                </div>
                                                <div class="mx-1">
                                                    <a class="btn btn-sm btn-outline-secondary" href="#">
                                                        xxxxx
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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
