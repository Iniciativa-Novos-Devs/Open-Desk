<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ValidadorCpsUsuarioController extends Controller
{
    public function validateCpsUser(Request $request)
    {
        $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3|string',
        ]);

        $response = $this->getRequestData([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $_validation_response = $response->json();
        $_valid = $_validation_response['valid'] ?? null;

        if (! $_valid) {
            return redirect()->route('logout');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function getRequestData(array $data)
    {
        $url = config('cps.cps_auth_url');

        if (! $url) {
            throw new Exception("Falha ao obter a URL da requição ao CPS. Config:  'cps.cps_auth_url'", 1);
        }

        $http_client = Http::withOptions([
            'debug' => env('# APP_DEBUG', false),
        ]);

        $http_client = $http_client->timeout(config('cps.cps_request_timeout'));

        if (! in_array(config('cps.cps_auth_method'), ['GET', 'POST'])) {
            throw new Exception("Falha. Método não aceito. São aceitos apenas GET ou POST. Config: 'cps.cps_auth_method'", 1);
        }

        if (config('cps.cps_auth_method') == 'GET') {
            return $http_client->asForm()->get($url, $data);
        }

        if (config('cps.cps_auth_method') == 'POST') {
            return $http_client->asForm()->post($url, $data);
        }
    }

    public function fakeCpsResponse(Request $request)
    {
        $allowed_emails = [
            'usuario1@mail.com',
            'admin@mail.com',
            'adm@adm.com',
        ];

        $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required|min:3|string',
        ]);

        $status_code = in_array($request->input('email'), $allowed_emails) ? 200 : 403;

        return response()->json([
            'valid' => ($status_code == 200 ? true : false),
        ], $status_code);
    }

    public function secondLogin()
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('logout');
        }

        $allow_admin_without_2f = config('cps.allow_admin_without_2f', true);
        $usuario_admin_local = (bool) $user->app_admin ?? false;

        // Caso permita que admin de app possa fazer login sem  validar no CPS.
        if ($allow_admin_without_2f && $usuario_admin_local) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return view('auth.2flogin');
    }
}
