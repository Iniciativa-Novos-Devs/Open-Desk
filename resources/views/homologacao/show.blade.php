@extends('layouts.page')

@inject('status_enum', 'App\Enums\StatusEnum')
@section('content')
    <div class="w-100">
        <h5> {{ $chamado->title ?? '(Chamado sem titulo)' }} </h5>
        <span class="text-muted">
            <ul>
                <li>Aberto em {{ $chamado->created_at->format('d/m/Y H:i:s') }} por: <a href="#">{{ $chamado->usuario->name }}</a></li>
            </ul>
        </span>

        <h5>Resolução</h5>
        <div class="p-2 my-3 border rounded border-dark w-100">

            <div class="p-2 border">
                {!! html_entity_decode($chamado->conclusion ?? null) !!}
            </div>


            <div class="p-2 mt-2">
                <span class="text-muted">
                    <ul>
                        <li>
                            Resolvido {{ $chamado->finished_at ? 'em '.$chamado->finished_at->format('d/m/Y H:i:s') : '' }} por:
                            <a href="#">{{ $chamado->atendente->name ?? null}}</a>
                        </li>
                    </ul>
                </span>
            </div>

            <div class="p-2 mt-2">
                @if ($chamado->status != $status_enum::HOMOLOGADO)
                <a href="@route('homologacao_homologar', [$chamado->id, 'no'])" class="btn btn-sm btn-outline-danger">Não homologar</a>
                <a href="@route('homologacao_homologar', [$chamado->id, 'yes'])" class="btn btn-sm btn-success">Homologar</a>
                @else
                <h6 class="text-muted">
                    Chamado homologado {{ $chamado->homologado_em ? 'em: '.$chamado->homologado_em->format('d/m/Y H:i') : '' }}
                </h6>
                @endif
            </div>
        </div>

        <div class="p-2 my-3 border rounded border-dark w-100">
            <h6>Anexos {{ $chamado->anexos ? '(' . count($chamado->anexos) . ')' : '' }}</h6>
            @if ($chamado->anexos)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Anexo</th>
                            <th scope="col">Tipo / mime</th>
                            <th scope="col">Tamanho</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chamado->anexos as $anexo)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $anexo['name'] ?? null }}</td>
                                <td>
                                    {{ ($anexo['extension'] ?? null) . ' | ' . ($mime_type = $anexo['mime_type'] ?? null) }}
                                </td>
                                <td>{{ humanFileSize($anexo['size'] ?? null) }}</td>
                                <td>
                                    <a href="#apagar" class="btn btn-sm btn-danger">Apagar</a>
                                    <a href="{{ asset($anexo['path']) }}" target="_blank" class="btn btn-sm btn-info">Ver</a>
                                    <a href="{{ asset($anexo['path']) }}" target="_blank" download="" class="btn btn-sm btn-info">Baixar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


    <hr>

    <h6>Histórico (últimos logs):</h6>
    <div class="w-100">
        <div class="accordion" id="accordionExample">
            @foreach ($chamado->logs as $log)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse_{{ $log->id }}"
                            aria-expanded="{{ $log->id == 1 ? 'true' : 'false' }}"
                            aria-controls="collapse_{{ $log->id }}">
                            {{ \App\Enums\ChamadoLogTypeEnum::getValue($log->type) }} |
                            {{ $log->usuario ? $log->usuario ->name : null }} |
                            <span class="text-muted">
                                {{ $log->created_at ?? null }}
                            </span>
                        </button>
                    </h2>
                    <div id="collapse_{{ $log->id }}"
                        class="accordion-collapse collapse {{ $loop->index == 0 ? 'show' : '' }}"
                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {!! html_entity_decode($log->content ?? null) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
