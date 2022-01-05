@extends('layouts.page')

@php
$role_show  = !! ($role_show ?? null);
$edit       = !! ($role->id ?? null);
$action     = $edit ? route('roles.update', $role->id) : route('roles.store');
$action_name = $edit ? 'Edit' : 'Create';
@endphp


@section('title', $_title = __($action_name. ' :item', ['item' => __('Role')]) . ': '. $role->name)
@section('title_header', $_title)

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ $action }}" method="post" class="row d-flex align-items-center flex-column">
            @csrf

            @if ($edit)

                <div class="form-group col-6 mb-3">
                    <label for="name">@lang('Name')</label>
                    <h6 class="form-control">{{ $role->name }}</h6>
                </div>

            @else
                <div class="form-group col-6 mb-3">
                    <label for="name">@lang('Name')</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name') ?? $role->name ?? '' }}">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endif

            <style>
                .form-check { padding: 5px 18px 5px 42px; }
                .form-check:hover { background: aliceblue; }
            </style>

            <div class="col-10">

                <div class="row">
                    <div class="col-12 mb-3">
                        @if(!$role_show)
                        <button
                            class="btn btn-sm btn-primary"
                            id="action_select_all" type="button" onclick="selectAll()">
                            @lang('Check all')
                        </button>

                        <button
                            class="btn btn-sm btn-warning"
                            id="action_select_none" type="button" onclick="selectNone()">
                            @lang('Uncheck all')
                        </button>

                        <button
                            class="btn btn-sm btn-success"
                            id="action_invert_selection" type="button" onclick="invertSelection()">
                            @lang('Invert selection')
                        </button>

                        @else
                        <a
                            class="btn btn-sm btn-primary"
                            href="@route('roles.edit', $role->id)"
                            type="button">
                            @lang('Edit :item', ['item' => __('role')])
                        </a>
                        @endif

                        <a
                            class="btn btn-sm btn-info"
                            href="@route('roles.index')"
                            type="button">
                            @lang('List of :items', ['items' => __('Roles')])
                        </a>
                    </div>
                </div>

                <div class="row">
                    @foreach ($items as $k => $item)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                            <div class="card shadow p-3 mb-5 bg-body rounded">
                                <div class="card-header" data-bs-toggle="collapse" href="#permissionsInputGroup" role="button"
                                    aria-expanded="false" aria-controls="permissionsInputGroup">
                                    <span class="item-filter-text">{{ $k }} group</span>
                                </div>
                                <div class="card-body collapse show" id="permissionsInputGroup">
                                    <div class="list-group">
                                        @foreach($item as $p)
                                            <div class="icheck-primary list-group-item">
                                                <input
                                                    class="form-check-input checkbox_permission me-1"
                                                    id="checkbox_permission_id_{{ $p['id'] }}"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $p['name'] }}"
                                                    {{ ($role_show ?? null) ? 'disabled' : '' }}
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

            <div class="form-group col-12 mb-3 d-flex align-items-end flex-column">
                @if ($role->id)
                <button class="btn btn-sm btn-outline-primary" type="submit">
                    @lang('Update')
                </button>
                @else
                <button class="btn btn-sm btn-outline-success" type="submit">
                    @lang('Save')
                </button>
                @endif
            </div>

        </form>
    </div>
</div>

<div class="modal fade" id="modal_role_permissions" tabindex="-1" aria-labelledby="modal_role_permissionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_role_permissionsLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="@lang('Close')"></button>
            </div>
            <div class="modal-body">
                <h6>@lang('Permissions of this role')</h6>
                <hr>
                <ul class="list-group list-group-flush" permissions-list></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

<script>
    var modal_role_permissions = document.getElementById('modal_role_permissions')
    modal_role_permissions.addEventListener('show.bs.modal', function (event) {
        var button      = event.relatedTarget
        var role_name   = button.getAttribute('data-role-name')
        var modalTitle      = modal_role_permissions.querySelector('.modal-title')

        var permissions_list    = modal_role_permissions.querySelector('[permissions-list]')

        var role_permissions    = button.getAttribute('data-role-permissions')

        if(role_permissions && isJson(role_permissions))
        {
            role_permissions = JSON.parse(role_permissions)
        } else {
            role_permissions = []
        }

        var list_items = role_permissions.map(function(permission){
            return '<li class="list-group-item">' + permission + '</li>'
        })

        permissions_list.innerHTML = list_items.join('');

        modalTitle.textContent = "@lang('Role'): " + role_name
    })

    modal_role_permissions.addEventListener('hidden.bs.modal', function (event) {
        console.log('hidden');
        var modalTitle = modal_role_permissions.querySelector('.modal-title')
        var permissions_list    = modal_role_permissions.querySelector('[permissions-list]')

        modalTitle.textContent = ''
        permissions_list.innerHTML = ''
    })
</script>


<script>
    function selectAll()
    {
        var inputs = document.querySelectorAll('input[type="checkbox"].checkbox_permission');
        if(inputs && inputs.length > 0)
        {
            inputs.forEach(input => {
                input.checked = true
            })
        }
    }

    function selectNone()
    {
        var inputs = document.querySelectorAll('input[type="checkbox"].checkbox_permission');
        if(inputs && inputs.length > 0)
        {
            inputs.forEach(input => {
                input.checked = false;
            })
        }
    }

    function invertSelection()
    {
        var inputs = document.querySelectorAll('input[type="checkbox"].checkbox_permission');
        if(inputs && inputs.length > 0)
        {
            inputs.forEach(input => {
                input.checked = !input.checked
            })
        }
    }

</script>
@endsection
