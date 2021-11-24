@extends('layouts.page')

@section('content')
<div class="col-12">
    <h5>Preferencias do usuario</h5>

    <hr>

    <h6>Preferencias desta sessão</h6>
    <pre>
        {{ json_encode($session_user_preferences, 128) }}
    </pre>

    <hr>
    <button
        type="button"
        class="btn
        btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#logoutOtherDevices">
        @lang("Disconnect other devices")
    </button>

    <div class="modal fade" id="logoutOtherDevices" tabindex="-1" aria-labelledby="logoutOtherDevicesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="@route('user.logout_other_devices')">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutOtherDevicesLabel">
                            @lang("Disconnect other devices")
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                            <div class="mb-3">
                                <h6>@lang("Please confirm your password before continuing.")</h6>
                            </div>

                            <div class="mb-3">
                                <label for="input_password">@lang('Password')</label>
                                <input type="password" class="form-control" id="input_password" name="password" placeholder="@lang('Password')" value="" required autocomplete="current-password">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
