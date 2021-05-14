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
                    <form class="col-12">
                        <div class="row p-0 m-0">
                            <div class="col-4 mx-0 mt-2 p-0 px-1">
                                <label for="select_esq">Selecione</label>
                                <select class="form-select mx-0 _bg-danger" id="selcet_esq"
                                    aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            <div class="col-8 mx-0 mt-2 p-0 px-1">
                                <label for="select_dir">Selecione</label>
                                <select class="form-select mx-0 _bg-warning" id="select_dir" required
                                    aria-label="Default select example">
                                    <option value='' selected>Escolha um problema</option>
                                    @foreach ($problemas as $problema)
                                        <option value='{{ $problema->id }}'>{{ $problema->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 my-3">
                                <textarea name="" id="" cols="30" rows="10" class="form-control template-ds"></textarea>
                            </div>

                            <div class="col-8 my-3">
                                <input type="file" class="form-control" name="" id="">
                            </div>

                            <div class="col-4 my-3">
                                <button type="submit" class="form-control">Cadastrar</button>
                            </div>
                        </div>
                    </form>

                    <div class="col-12">
                        <hr class="w-100">
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>head</th>
                                    <th>head</th>
                                    <th>head</th>
                                </tr>
                                <tr>
                                    <td>value</td>
                                    <td>value</td>
                                    <td>value</td>
                                </tr>
                                <tr>
                                    <td>value</td>
                                    <td>value</td>
                                    <td>value</td>
                                </tr>
                            </tbody>
                        </table>
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
