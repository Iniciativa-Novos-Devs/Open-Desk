@extends('layouts.page')

@section('head')
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('js')
    //https://ckeditor.com/docs/ckeditor5
    //https://cdn.ckeditor.com/#ckeditor5

    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/translations/pt-br.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/plugins/fontsize.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#observacao'), {
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
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

    </script>
@endsection

@section('content')
    <style>
        .faq-container select {
            height: 25vh;
            ;
        }

        textarea.template-ds {
            min-height: 25vh;
            max-height: 50vh;
        }

    </style>

    <div class="container-box">
        <div class="p-0 m-0 row">
            <div class="mt-0 col-8 _bg-danger">
                <div class="row">
                    <form class="col-12" method="POST" action="{{ route('chamados_store') }}"
                        enctype="multipart/form-data">

                        @csrf

                        @livewire('chamado-problema-area-select')

                        <div class="row">
                            <div class="my-3 col-12 form-group">
                                <label for="title">Título do Problema</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" id="title" minlength="5"
                                    maxlength="100" placeholder="Título do Problema">
                            </div>

                            <div class="my-3 col-12">
                                <textarea name="observacao" id="observacao" cols="30" rows="10" minlength="10"
                                    class="form-control template-ds">{{ old('observacao') ?? null }}</textarea>
                            </div>

                            <div class="my-3 col-12">
                                <div class="row">
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="anexos[]" id="anexo_1">
                                    </div>
                                    <div class="col-2">Adicionar</div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="file" class="form-control" name="anexos[]" id="anexo_2">
                                    </div>
                                    <div class="col-2">Adicionar</div>
                                </div>
                            </div>

                            <div class="col-12 row">
                                <div class="col-4">
                                </div>

                                <div class="col-4">
                                    <button type="submit" name="create_another" id="create_another" value="yes"
                                        class="form-control btn bnt-md btn-outline-success">Cadastrar e permanecer</button>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="form-control btn bnt-md btn-success">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="col-12">
                        <hr class="w-100">
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                @livewire('chamado-list', ['items_by_page' => 10,])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 col-4 _bg-warning">
                <div class="p-0 m-0 mt-3 row">
                    <div class="px-0 mb-1 border col-12 faq-container">
                        <select class="px-0 mx-0 form-select" size="3" aria-label="size 3 select example">
                            <option disabled>FAQ GERAL</option>
                            <option value="1">Link para o FAQ1</option>
                            <option value="2">Link para o FAQ2</option>
                            <option value="3">Link para o FAQ3</option>
                            <option value="4">Link para o FAQ4</option>
                            <option value="5">Link para o FAQ5</option>
                            <option value="6">Link para o FAQ6</option>
                            <option value="7">Link para o FAQ7</option>
                            <option value="8">Link para o FAQ8</option>
                            <option value="9">Link para o FAQ9</option>
                            <option value="10">Link para o FAQ10</option>
                            <option value="11">Link para o FAQ11</option>
                        </select>
                    </div>

                    <div class="px-0 mb-1 border col-12 faq-container">
                        <select class="px-0 mx-0 form-select" size="3" aria-label="size 3 select example">
                            <option disabled>FAQ ESPECÍFICO DA UNIDADE</option>
                            <option value="1">Link para o FAQ1</option>
                            <option value="2">Link para o FAQ2</option>
                            <option value="3">Link para o FAQ3</option>
                            <option value="4">Link para o FAQ4</option>
                            <option value="5">Link para o FAQ5</option>
                            <option value="6">Link para o FAQ6</option>
                            <option value="7">Link para o FAQ7</option>
                            <option value="8">Link para o FAQ8</option>
                            <option value="9">Link para o FAQ9</option>
                            <option value="10">Link para o FAQ10</option>
                            <option value="11">Link para o FAQ11</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
