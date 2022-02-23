@extends('layouts.page')

@section('content')
<div class="col-12" x-data="{
    show_password: false,
}">
    <div class="row mb-3">
        <h5>Preferencias do usuario</h5>
        <hr>
        <h6>Preferencias desta sessão</h6>
        <pre>
            {{ json_encode($session_user_preferences, 128) }}
        </pre>
    </div>

    <hr>

    <div class="row">
        <div class="col-4">
            <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action btn-secondary"
                    data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    @lang("Change password")
                </button>

                <button type="button" class="list-group-item list-group-item-action btn-primary" data-bs-toggle="modal"
                    data-bs-target="#logoutOtherDevices">
                    @lang("Disconnect other devices")
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="@route('user.preferences.change_password')">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">
                            @lang("Change password")
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <h6>@lang("Please confirm your password before continuing.")</h6>
                        </div>

                        <div class="mb-3">
                            <label for="input_current_password">@lang('Current password')</label>
                            <input class="form-control" id="input_current_password"
                                placeholder="@lang('Current password')"
                                :type="show_password ? 'text' : 'password'"
                                name="current_password" placeholder="@lang('Current password')" value="" required
                                autocomplete="current-password">

                            @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="input_new_password">@lang('New password')</label>
                            <input class="form-control" id="input_new_password" name="new_password"
                                placeholder="@lang('New password')"
                                :type="show_password ? 'text' : 'password'"
                                placeholder="@lang('New password')" value="" required autocomplete="new-password">

                            @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <small class="text-muted">@lang('You password must to have more than 6 characters')</small>
                        </div>

                        <div class="mb-3">
                            <label for="input_repeat_new_password">@lang('Repeat new password')</label>
                            <input class="form-control" id="input_repeat_new_password"
                                placeholder="@lang('Repeat new password')"
                                :type="show_password ? 'text' : 'password'"
                                name="repeat_new_password" placeholder="@lang('Repeat new password')" value="" required
                                autocomplete="repeat_new-password">

                            @error('repeat_new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="w-100">
                                <button type="button" class="btn btn-sm btn-outline-info" @click="show_password = !show_password">
                                    <span x-text="show_password ? '@lang("Show password")' : '@lang("Hide password")'"></span>
                                    <i class="bi" :class="{'bi-eye-fill': !show_password, 'bi-eye-slash-fill':show_password }"></i>
                                </button>
                            </div>

                            <div class="w-100">
                                <small class="text-muted">
                                    @lang("If you don't want to change your password, just leave the fields empty.")
                                </small>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-primary" disabled readonly>@lang('Change')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutOtherDevices" tabindex="-1" aria-labelledby="logoutOtherDevicesLabel"
        aria-hidden="true">
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
                            <input type="password" class="form-control" id="input_password" name="password"
                                placeholder="@lang('Password')" value="" required autocomplete="current-password">
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

    <script>
        function newPasswordIsValid()
        {
            var currentPassword = document.querySelector('[name="current_password"]');
            var newPassword = document.querySelector('[name="new_password"]');
            var repeatNewPassword = document.querySelector('[name="repeat_new_password"]');
            var submitButton = document.querySelector("#changePasswordModal").querySelector("button[type=submit]");

            if (
                !currentPassword ||
                !newPassword ||
                !repeatNewPassword
            )
            {
                return null;
            }

            if (
                (currentPassword.value.length >= 4) &&
                (newPassword.value.length >= 6) &&
                (newPassword.value === repeatNewPassword.value)
            )
            {
                submitButton.disabled = false;
                repeatNewPassword.setCustomValidity("");
                return;
            }
            submitButton.disabled = true;
            repeatNewPassword.setCustomValidity("@lang('Passwords do not match.')");
        }

        document.querySelector('[name="current_password"]').addEventListener('keyup', newPasswordIsValid);
        document.querySelector('[name="new_password"]').addEventListener('keyup', newPasswordIsValid);
        document.querySelector('[name="repeat_new_password"]').addEventListener('keyup', newPasswordIsValid);
    </script>

</div>
@endsection
