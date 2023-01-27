@extends('layouts.page')

@section('title_header', __('Add new :item', ['item' => 'ticket']))
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

    <div class="container-fluid m-0 p-0">
        <div class="row m-0 p-0">
            <div class="mt-3 col-xl-8 col-md-12 col-sm-12 m-0 p-0">
                <div class="row m-0 p-0">
                    <form class="col-12 m-0 p-0" method="POST" action="{{ route('chamados_store') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        @livewire('chamado-problema-area-select')

                        <div class="row p-0 m-0">
                            <div class="col-md-12 col-sm-12 mx-0 mt-2 p-0 px-1">
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
                                <div class="rounded border p-1">

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
                                                    `{{
                                                        trans_choice(
                                                            'Maximum attachment limit is :count files',
                                                            config('cps.max_atachment_inputs')
                                                        )
                                                    }}`;
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
                                                <input type="file" class="form-control flex-grow-1 align-self-stretch" name="anexos[]" id="anexo_1">

                                                <button
                                                    class="btn btn-primary p-0 px-2 flex-grow-1 align-self-stretch"
                                                    title="@lang('Add new :item', ['item' => __('atachment')])"
                                                    type="button"
                                                    onclick="atachmentRemoveInput('${random_id}')"
                                                    style="color: #ffffff;background: #d12a2a;margin-left: 0.5rem !important;margin-right: 0.2rem !important;;width: 2.3rem !important;align-self: baseline !important;padding: 0.15rem !important;"
                                                >
                                                    <strong
                                                        style="font-size: 1.3rem;padding: 0 !important;margin: 0 !important;padding: 0 0.2rem !important;"
                                                    >-
                                                    </strong>
                                                </button>
                                            `

                                            var input_line_container = document.createElement('div');
                                            input_line_container.classList.add('d-flex');
                                            input_line_container.classList.add('bd-highlight');
                                            input_line_container.classList.add('mb-4');
                                            input_line_container.classList.add('m-0');
                                            input_line_container.classList.add('p-0');
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
                                        <div class="col-12 text-center">
                                            <h5 class="text-center">@lang('Atachments')</h5>
                                        </div>

                                        <div class="col-12 text-center">
                                            <span class="text-danger d-none" data-msg-type="error">

                                            </span>
                                        </div>
                                    </div>

                                    <div atachment-container="">
                                        <div class="d-flex bd-highlight mb-4 m-0 p-0">
                                            <input type="file" class="form-control flex-grow-1 align-self-stretch" name="anexos[]" id="anexo_1">
                                            @if (config('cps.max_atachment_inputs', 1) > 1)
                                            <button
                                                class="btn btn-primary p-0 px-2 flex-grow-1 align-self-stretch"
                                                title="@lang('Add new :item', ['item' => __('atachment')])"
                                                type="button"
                                                onclick="atachmentAddNewInput()"
                                                style="color: #212f3c;background: cornflowerblue;margin-left: 0.5rem !important;margin-right: 0.2rem !important;;width: 2.3rem !important;align-self: baseline !important;padding: 0.15rem !important;"
                                            >
                                                <strong
                                                    style="font-size: 1.3rem;padding: 0 !important;margin: 0 !important;padding: 0 0.2rem !important;"
                                                >+
                                                </strong>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 d-md-none mt-3"></div>

                                    <div class="col-md-6 col-sm-12 d-grid gap-2">
                                        <button type="submit" name="create_another" id="create_another" value="yes"
                                            class="form-control btn bnt-md btn-outline-success">Cadastrar e permanecer</button>
                                    </div>

                                    <div class="col-12 d-md-none mt-3"></div>

                                    <div class="col-md-6 col-sm-12 d-grid gap-2">
                                        <button type="submit" class="form-control btn bnt-md btn-success">Cadastrar</button>
                                    </div>
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

            <div class="mt-3 col-xl-4 col-md-12 col-sm-12 m-0 p-0">
                <div class="p-0 m-0 mt-3 row">
                    <div class="px-0 mb-1 border faq-container col-xl-12 col-md-6 col-sm-12">
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

                    <div class="px-0 mb-1 border faq-container col-xl-12 col-md-6 col-sm-12">
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
