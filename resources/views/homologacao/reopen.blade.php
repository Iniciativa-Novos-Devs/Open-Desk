@extends('layouts.page')

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

        <h5>Reabrir o chamado</h5>
        <div class="p-2 p-4 my-3 border rounded border-dark w-100">
            <form class="row" method="POST" action="@route('homologacao_update', [$chamado->id, $concluir])">
                @csrf

                <div class="my-3 col-12">
                    <div class="mb-1 w-100">
                        <h5>Informe o motivo pelo qual não homologa este atendimento</h5>
                        <h6 class="text-muted">O mesmo será reaberto</h6>
                    </div>

                    <textarea name="homologacao_nota" id="homologacao_nota" cols="30" rows="10" minlength="10"
                        class="form-control template-ds d-none">{{ old('homologacao_nota') ?? null }}</textarea>
                </div>

                <div class="col-12">
                    <div class="mb-3 w-100">
                        <button class="btn btn-md btn-outline-danger" type="submit">Reabrir este chamado</button>
                    </div>

                    <div class="w-100">
                        <a href="@route('homologacao_homologar', [$chamado->id, 'yes'])" class="text-muted">Caso queira homologar (encerrar), clique aqui</a>
                    </div>
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
                            <a href="#">{{ $chamado->atendente->name ?? null }}</a>
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
                height: 1000,

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
