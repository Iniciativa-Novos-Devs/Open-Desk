@extends('layouts.page')

@section('title', __('User') . ': '. $usuario->name)
@section('title_header', __('User') . ': '. $usuario->name)

@section('content')
<div class="row">
    <div class="col-12">
        <table class="table">
            <tbody>
                <tr>
                    <td colspan="100%">
                        <a href="@route('usuarios.index')" class="btn btn-sm btn-outline-primary">@lang('See all')</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">@lang('Actions')</th>
                    <td>
                        @if (\Auth::user()->id != $usuario->id)
                            <a href="@route('usuarios.delete', $usuario->id)" class="btn btn-sm btn-danger">@lang('Delete')</a>
                            <a href="#!" class="btn btn-sm btn-outline-warning">@lang('Inactivate')</a>
                        @endif

                        <a href="@route('usuarios.edit', $usuario->id)" class="btn btn-sm btn-outline-primary">@lang('Edit')</a>

                    </td>
                </tr>
                <tr>
                    <th scope="row">ID</th>
                    <td>{{ $usuario->id }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('Name')</th>
                    <td>{{ $usuario->name }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('E-mail')</th>
                    <td>{{ $usuario->email }}</td>
                </tr>
                <tr>
                    <th scope="row">@lang('UE')</th>
                    <td>{{ $usuario->ue }}</td>
                </tr>
                <tr>
                    <th scope="row">Telefone #1</th>
                    <td>
                        {{ $usuario->telefone_1 }}
                        {{ $usuario->telefone_1_wa ? '(WhatsApp)' : '' }}
                    </td>
                </tr>
                <tr>
                    <th scope="row">@lang('Security')</th>
                    <td>
                        <a href="#roles" class="btn btn-sm btn-outline-secondary">@lang('Roles')</a>
                        <a href="#permissions" class="btn btn-sm btn-outline-info">@lang('Permissions')</a>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection
