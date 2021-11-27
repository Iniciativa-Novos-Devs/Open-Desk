@extends('layouts.page')

@section('content')
<div class="row">
    <div class="col-12">
        <x-bs-table-paginate :data="$usuarios" :columns="$columns" :actions="$actions" />
    </div>
</div>
@endsection
