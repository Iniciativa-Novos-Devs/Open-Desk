@extends('layouts.page')

@section('content')
<div class="w-100">
    <h2> {{ $chamado['titulo'] }}</h2>
    <h4> {{ $chamado['usuario'] }}</h4>

    <div>
        <p>
            {{ $chamado['conteudo'] }}
        </p>
    </div>
</div>

<hr>

<h6>Histórico:</h6>
<div class="w-100">
    <div class="accordion" id="accordionExample">
        @php
        $index = 1;
        @endphp
        @foreach ($historico as $h)
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse_{{ $index }}" aria-expanded="{{ $index == 1 ? 'true' : 'false' }}"
                    aria-controls="collapse_{{ $index }}">
                    {{ $h['titulo'] }} |
                    {{ $h['usuario'] }} |
                    {{ $index }} |
                    <span class="text-muted">
                        {{ $h['data'] }}
                    </span>
                </button>
            </h2>
            <div id="collapse_{{ $index }}" class="accordion-collapse collapse {{ $index == 1 ? 'show' : '' }}"
                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    {{ nl2br($h['conteudo']) }}
                </div>
            </div>
        </div>
        @php
        $index++;
        @endphp
        @endforeach
    </div>
</div>
@endsection