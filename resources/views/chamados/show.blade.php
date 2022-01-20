@extends('layouts.page')


@php
    function humanFileSize($size, $unit="")
    {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)." GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)." MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)." KB";
        return number_format($size)." bytes";
    }
@endphp
@section('content')
    <div class="w-100">
        <h5> {{ $chamado->title ?? '(Chamado sem titulo)' }} </h5>
        <span class="text-muted"><a href="#">{{ $chamado->usuario->name }}</a> |
            {{ $chamado->created_at->format('d/m/Y H:i:s') }} </span>

        <div class="p-2 my-3 border rounded border-dark w-100">
            {!! html_entity_decode($chamado->observacao ?? null) !!}
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
                        @foreach ($chamado->anexos as $index => $anexo)
                            <tr>
                                <th scope="row">{{ $index +1 }}</th>
                                <td>{{ $anexo['name'] ?? null }}</td>
                                <td>
                                    {{ ($anexo['extension'] ?? null) . ' | ' . ($mime_type = $anexo['mime_type'] ?? null) }}
                                </td>
                                <td>{{ humanFileSize($anexo['size'] ?? null) }}</td>
                                <td>
                                    <a
                                        href="@route('chamados_delete_atachment', [$chamado->id, ($anexo['id'] ?? null)])"
                                        onclick="if (! confirm('Deseja mesmo deletar o anexo {{ $anexo['name'] ?? null }}?')) { return false; }"
                                        class="btn btn-sm btn-danger">
                                        Apagar
                                    </a>
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
