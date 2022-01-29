@extends('layouts.page')

@section('content')
<div class="row pt-4">
    <div class="col-12">
        <div class="row">
            <div class="col-md-4 col-sm-6"></div>
            <div class="col-md-4 col-sm-6"></div>
            <div class="col-md-4 col-sm-6">
                <a href="@route('users.massive-import.form')" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-cloud-upload"></i>
                    @lang('Import :items via sheet', ['items' => __('Users') ])
                </a>
            </div>
        </div>
    </div>

    <div class="col-12">
        <x-bs-table-paginate :data="$usuarios" :columns="$columns" :actions="$actions" />
    </div>
</div>
@endsection
