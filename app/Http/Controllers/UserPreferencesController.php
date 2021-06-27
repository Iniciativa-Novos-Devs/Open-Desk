<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class UserPreferencesController extends Controller
{
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

    public static function routes()
    {
        Route::get('user/preferences', [self::class, 'preferences'])->name('user.preferences');
    }
}
