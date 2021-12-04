@extends('layouts.page')

@php
$action = ($usuario->id ?? null) ? route('usuarios.update', $usuario->id) : route('usuarios.store');
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <form action="{{ $action }}" method="post" class="row d-flex align-items-center flex-column">
            @csrf

            <div class="form-group col-6 mb-3">
                <label for="name">@lang('Name')</label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name') ?? $usuario->name ?? '' }}">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-6 mb-3">
                <label for="email">@lang('E-mail')</label>
                <input type="text" id="email" name="email" class="form-control"
                    value="{{ old('email') ?? $usuario->email ?? '' }}">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <style>
                .form-check { padding: 5px 18px 5px 42px; }
                .form-check:hover { background: aliceblue; }
            </style>
            <div class="form-group col-6 mb-3">
                <h6>@lang('Roles')</h6>
                    @foreach ($roles as $role)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            id="checkbox_role_id_{{ $role->id }}"
                            type="checkbox"
                            name="user_roles[]"
                            value="{{ $role->name }}"
                            {{ $usuario_roles->contains($role->name) ? 'checked' : '' }}>

                        <label class="form-check-label align-self-center d-flex justify-content-between" for="checkbox_role_id_{{ $role->id }}">
                            {{ $role->name }}
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-info"
                                data-bs-toggle="modal"
                                data-bs-target="#modal_role_permissions"
                                data-role-name="{{ $role->name }}"
                                data-role-permissions="{{ json_encode($role->permissions->pluck('name')) }}"
                                >
                                @lang('See all permissions of this role')
                            </button>
                        </label>
                    </div>
                    @endforeach
            </div>

            <div class="form-group col-6 mb-3 d-flex align-items-end flex-column">
                @if ($usuario->id)
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
@endsection
