@extends('layouts.page')

@section('title', __('Role') . ': '. $role->name)
@section('title_header', __('Role') . ': '. $role->name)

@section('content')
<div class="row">
    <div class="col-12">
        <table class="table">
            <tbody>
                <tr>
                    <td colspan="100%">
                        <a href="@route('roles.index')" class="btn btn-sm btn-outline-primary">@lang('See all')</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">@lang('Actions')</th>
                    <td>
                        @if (!\Auth::user()->hasRole($role))
                        <a href="@route('roles.delete', $role->id)" class="btn btn-sm btn-danger">@lang('Delete')</a>
                        <a href="#!" class="btn btn-sm btn-outline-warning">@lang('Inactivate')</a>
                        @endif

                        <a href="@route('roles.edit', $role->id)"
                            class="btn btn-sm btn-outline-primary">@lang('Edit')</a>

                    </td>
                </tr>
                <tr>
                    <th scope="row">ID</th>
                    <td>{{ $role->id }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('Name')</th>
                    <td>{{ $role->name }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('Security')</th>
                    <td>
                        <button
                            class="btn btn-sm btn-outline-info"
                            data-bs-toggle="collapse" href="#permissionsInputGroup" role="button"
                            aria-expanded="false" aria-controls="permissionsInputGroup"
                            >
                            @lang('Permissions')
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row collapse" id="permissionsInputGroup">
        @foreach ($items as $k => $item)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
            <div class="card shadow p-3 mb-5 bg-body rounded">
                <div class="card-header">
                    <span class="item-filter-text">{{ $k }} group</span>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($item as $p)
                        <div class="icheck-primary list-group-item">
                            <input class="form-check-input checkbox_permission me-1"
                                id="checkbox_permission_id_{{ $p['id'] }}" type="checkbox" name="permissions[]"
                                disabled
                                {{ ($p['checked']) ? 'checked' : '' }}>
                            <label for="checkbox_permission_id_{{ $p['id'] }}"> {{ $p['name'] }} </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
