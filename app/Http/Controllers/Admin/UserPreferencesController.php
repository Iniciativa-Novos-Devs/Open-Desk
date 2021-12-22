<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class UserPreferencesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function routes()
    {
        Route::post('desconectar-outros-dispositivos', [self::class, 'logoutOtherDevices'])->name('user.logout_other_devices');
        Route::get('user/preferences', [self::class, 'preferences'])->name('user.preferences');
    }

    public function preferences(Request $request)
    {
        return view('user_preferences.index', [
            'session_user_preferences' => session()->get('user_preferences', []),
        ]);
    }

    public static function changeBooleanState(string $option_name)
    {
        $option_value  = session()->get('user_preferences.'. $option_name, 'NO_DATA');

        if($option_value === 'NO_DATA')
        {
            session()->put('user_preferences.'. $option_name, ($option_value = false));
            return;
        }

        session()->put('user_preferences.'. $option_name, !$option_value);
        $option_value = session()->get('user_preferences.'. $option_name, 'NO_DATA');
    }

    /**
     * function logoutOtherDevices
     *
     * @param Request $request
     * @return
     */
    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:5',
        ]);

        \Auth::logoutOtherDevices($request->input('password'));

        return back()->with('success', __('Other devices disconnected successfully'));
    }
}
