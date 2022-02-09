@extends('layouts.page')

@php
    $lastImportedReport = storage_path('logs/usuarios_cadastrados.xlsx');
@endphp

@section('content')
<div class="row pt-4">
    <div class="col-12">
        <div class="row">
            <div class="col-md-2 col-sm-6"></div>
            <div class="col-md-4 col-sm-6"></div>
            <div class="col-md-6 col-sm-6 d-flex justify-content-end">
                <a href="@route('usuarios.massive-import.form')" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-cloud-upload"></i>
                    @lang('Import :items via sheet', ['items' => __('Users') ])
                </a>

                @if (file_exists($lastImportedReport))
                    <a href="@route('usuarios.massive-import.imported_report_download')" class="btn btn-sm btn-outline-primary mx-2">
                        <i class="bi bi-cloud-download"></i>
                        @lang('Download the last imported :items', ['items' => __('Users') ])
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12">
        <x-bs-table-paginate :data="$usuarios" :columns="$columns" :actions="$actions" />
    </div>
</div>
@endsection
