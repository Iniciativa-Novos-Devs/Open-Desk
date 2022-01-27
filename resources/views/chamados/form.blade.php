@extends('layouts.page')

@section('head')
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('js')
    {{-- https://ckeditor.com/docs/ckeditor5 --}}
    {{-- https://cdn.ckeditor.com/#ckeditor5 --}}

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
                // console.log(editor);
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
                                    maxlength="100" placeholder="Título do Problema" required>
                            </div>

                            <div class="my-3 col-12">
                                <div class="rounded border p-4">
                                    <div class="row mb-2">
                                        <h5>@lang('Note')</h5>
                                    </div>

                                    <textarea name="observacao" id="observacao" minlength="10"
                                        class="form-control template-ds">{{ old('observacao') ?? null }}</textarea>
                                </div>
                            </div>

                            <div class="my-3 col-12">
                                <div class="rounded border p-4">

                                    <script>
                                        function atachmentAddNewInput()
                                        {
                                            var atachment_container = document.querySelector('[atachment-container]');

                                            if(!atachment_container)
                                            {
                                                console.log('atachment_container not found');
                                                return;
                                            }

                                            var max_atachment_inputs = {{ config('cps.max_atachment_inputs', 1) }};
                                            var total_childs         = atachment_container.childElementCount;
                                            console.log('total_childs: ' + total_childs, 'max_atachment_inputs: ' + max_atachment_inputs);

                                            var atachment_error_message_el = document.querySelector('[data-msg-type="error"]');

                                            if(total_childs >= max_atachment_inputs)
                                            {
                                                if(atachment_error_message_el)
                                                {
                                                    atachment_error_message_el.innerHTML =
                                                    `@lang('You can not add more than :max_atachment_inputs files', [
                                                        'max_atachment_inputs' => __(config('cps.max_atachment_inputs'))
                                                    ])`;
                                                    atachment_error_message_el.classList.remove('d-none');
                                                }

                                                console.log('max_atachment_inputs reached');
                                                return;
                                            }

                                            if(atachment_error_message_el)
                                            {
                                                atachment_error_message_el.innerHTML = '';
                                                atachment_error_message_el.classList.add('d-none');
                                            }

                                            var random_id = window.uuidv4 ? uuidv4() :
                                                Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);

                                            var input_line = `
                                                <div class="col-10">
                                                    <input type="file" class="form-control" name="anexos[]" id="anexo_2">
                                                </div>
                                                <div class="col-2">
                                                    <button
                                                        class="btn btn-primary p-0 px-4"
                                                        title="@lang('Add new :item', ['item' => __('atachment')])"
                                                        type="button" onclick="atachmentAddNewInput()">
                                                        <i style=" color: cornflowerblue;font-size: 1.3rem;" class="bi-file-plus-fill"></i>
                                                    </button>

                                                    <button
                                                        class="btn btn-outline-danger p-0 px-4"
                                                        title="@lang('Add new :item', ['item' => __('atachment')])"
                                                        type="button" onclick="atachmentRemoveInput('${random_id}')">
                                                        <i style=" color: cornflowerred;font-size: 1.3rem;" class="bi bi-file-minus-fill"></i>
                                                    </button>
                                                </div>
                                            `

                                            var input_line_container = document.createElement('div');
                                            input_line_container.classList.add('row');
                                            input_line_container.classList.add('mb-2');
                                            input_line_container.setAttribute('data-uuid', random_id);
                                            input_line_container.innerHTML = input_line;

                                            atachment_container.appendChild(input_line_container);
                                        }

                                        function atachmentRemoveInput(uuid)
                                        {
                                            var element_to_remove = document.querySelector(`[data-uuid="${uuid}"]`);
                                            if(element_to_remove)
                                            {
                                                element_to_remove.remove();
                                            }

                                            var atachment_error_message_el = document.querySelector('[data-msg-type="error"]');

                                            if(atachment_error_message_el)
                                            {
                                                atachment_error_message_el.innerHTML = '';
                                                atachment_error_message_el.classList.add('d-none');
                                            }
                                        }
                                    </script>

                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <h5>@lang('Atachments')</h5>
                                        </div>

                                        <div class="col-6 text-center">
                                            <span class="text-danger d-none" data-msg-type="error">

                                            </span>
                                        </div>
                                    </div>

                                    <div atachment-container="">
                                        <div class="row mb-2">
                                            <div class="col-10">
                                                <input type="file" class="form-control" name="anexos[]" id="anexo_1">
                                            </div>
                                            <div class="col-2">
                                                <button
                                                    class="btn btn-primary p-0 px-4"
                                                    title="@lang('Add new :item', ['item' => __('atachment')])"
                                                    type="button" onclick="atachmentAddNewInput()">
                                                    <i style=" color: cornflowerblue;font-size: 1.3rem;" class="bi-file-plus-fill"></i>
                                                </button>
                                            </div>
                                        </div>


                                    </div>
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
                                @livewire('chamado-list', ['items_by_page' => 5,])
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
