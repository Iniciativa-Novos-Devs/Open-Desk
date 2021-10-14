@extends('layouts.page')

@php
function humanFileSize($size, $unit = '')
{
    if ((!$unit && $size >= 1 << 30) || $unit == 'GB') {
        return number_format($size / (1 << 30), 2) . ' GB';
    }
    if ((!$unit && $size >= 1 << 20) || $unit == 'MB') {
        return number_format($size / (1 << 20), 2) . ' MB';
    }
    if ((!$unit && $size >= 1 << 10) || $unit == 'KB') {
        return number_format($size / (1 << 10), 2) . ' KB';
    }
    return number_format($size) . ' bytes';
}
@endphp

@section('head_content')
    <link rel="stylesheet" href="@asset('pure-css-star-rating-input/dist/style.css')">
    {{-- <script src="@asset('pure-css-star-rating-input/dist/script.js')"></script> --}}

    <script>
        addScriptToAppendAfterLoad("@asset('pure-css-star-rating-input/dist/script.js')")
    </script>
@endsection

@section('content')
    <div class="w-100">
        <h5> {{ $chamado->title ?? '(Chamado sem titulo)' }} </h5>
        <span class="text-muted">
            <ul>
                <li>Aberto em {{ $chamado->created_at->format('d/m/Y H:i:s') }} por: <a
                       href="#">{{ $chamado->usuario->name }}</a></li>
            </ul>
        </span>

        <h5>Avalie o atendimento</h5>
        <div class="p-2 p-4 my-3 border rounded border-dark w-100">
            <form class="row" method="POST" action="@route('homologacao_update', $chamado->id)">
                @csrf

                <div class="mb-3 col-12">
                    <div class="rating w-100">
                        <label>
                            <input type="radio" name="rating" value="1" required>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="2" required>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="3" required>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="4" required>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="rating" value="5" required>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                    </div>
                </div>

                <hr>

                <div class="my-3 col-12">
                    <div class="mb-1 w-100">
                        <h5>Nota opcional para o atendimento</h5>
                    </div>

                    <textarea name="homologacao_nota" id="homologacao_nota" cols="30" rows="10" minlength="10"
                        class="form-control template-ds">{{ old('homologacao_nota') ?? null }}</textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-md btn-success" type="submit">Homologar</button>
                </div>
            </form>
        </div>

        <hr>

        <h5>Resolução</h5>
        <div class="p-2 my-3 border rounded border-dark w-100">

            <div class="p-2 border">
                {!! html_entity_decode($chamado->conclusion ?? null) !!}
            </div>


            <div class="p-2 mt-2">
                <span class="text-muted">
                    <ul>
                        <li>
                            Resolvido
                            {{ $chamado->finished_at ? 'em ' . $chamado->finished_at->format('d/m/Y H:i:s') : '' }} por:
                            <a href="#">{{ $chamado->homologadoPor->name ?? null }}</a>
                        </li>
                    </ul>
                </span>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- https://ckeditor.com/docs/ckeditor5 --}}
    {{-- https://cdn.ckeditor.com/#ckeditor5 --}}

    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/translations/pt-br.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/plugins/fontsize.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#homologacao_nota'), {
                language: 'pt-br',

                //https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', '|',
                        'link', '|',
                        'outdent', 'indent', '|',
                        'bulletedList', 'numberedList', '|',
                        'insertTable', '|',
                        'blockQuote', '|',
                        'undo', 'redo',
                    ],
                    shouldNotGroupWhenFull: true,
                }
            })
            .then(editor => {
                // console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

    </script>
@endsection
