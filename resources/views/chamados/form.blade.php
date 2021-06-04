@extends('layouts.page')

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
        <div class="row p-0 m-0">
            <div class="col-8 mt-0 _bg-danger">
                <div class="row">
                    <form class="col-12" method="POST" action="{{ route('chamados_store') }}" enctype="multipart/form-data">

                        @csrf

                        @livewire('chamado-problema-area-select')

                        <div class="row">
                            <div class="col-12 my-3">
                                <textarea name="observacao" id="observacao" cols="30" rows="10"
                                    minlength="10"
                                    class="form-control template-ds">{{ old('observacao') ?? null }}</textarea>
                            </div>

                            <div class="col-12 my-3">
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
                                    <button type="submit" name="create_another" id="create_another" value="yes" class="form-control">Cadastrar e voltar</button>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="form-control">Cadastrar</button>
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

            <div class="col-4 mt-3 _bg-warning">
                <div class="row row p-0 m-0 mt-3">
                    <div class="col-12 mb-1 border faq-container px-0">
                        <select class="form-select mx-0 px-0" size="3" aria-label="size 3 select example">
                            <option disabled>FAQ 01</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div class="col-12 mb-1 border faq-container px-0">
                        <select class="form-select mx-0 px-0" size="3" aria-label="size 3 select example">
                            <option disabled>FAQ 02</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
