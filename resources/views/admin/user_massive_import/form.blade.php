@extends('layouts.page')

@section('content')

<style>
    .form-check {
        padding: 5px 18px 5px 42px;
    }

    .form-check:hover {
        background: aliceblue;
    }
</style>

<div class="row pt-4">
    <div class="col-12 mb3 text-center">
        <h6>@lang('Import :items via sheet', ['items' => __('users')])</h6>
    </div>

    <div class="col-12">
        <form action="@route('usuarios.massive-import.upload')" method="post"
            class="row d-flex align-items-center flex-column" enctype="multipart/form-data">
            @csrf

            <div class="form-group col-6 mb-3">
                <label for="massive_file" class="form-label">@lang('Import sheet file')</label>
                <input class="form-control" id="massive_file" name="massive_file"
                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" type="file" required>

                @error('massive_file') <span class="text-danger">{{ $message }}</span> @enderror
            </div>


            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="row justify-content-between">
                            <div class="col-12 d-md-none mt-5"></div>

                            <div class="col-md-4 col-sm-4 d-grid gap-2">
                                <a download="importacao-usuario-demo.xlsx"
                                    href="{{ asset('demo/docs/importacao-usuario-demo.xlsx') }}"
                                    class="btn bnt-md btn-link">
                                    <i class="bi bi-cloud-download"></i>
                                    @lang('Download demo sheet')
                                </a>
                            </div>

                            <div class="col-12 d-md-none mt-5"></div>

                            <div class="col-md-4 col-sm-4 d-grid gap-2">
                                <button class="btn bnt-md btn-success" class="btn btn-success" type="submit">
                                    <i class="bi bi-cloud-upload"></i>
                                    @lang('Upload and import')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-6 mb-3 d-flex align-items-end flex-column">


            </div>

        </form>
    </div>
</div>
@endsection
