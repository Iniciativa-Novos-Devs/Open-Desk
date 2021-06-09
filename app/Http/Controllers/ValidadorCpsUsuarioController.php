<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Exception;

class ValidadorCpsUsuarioController extends Controller
{
    public function validateCpsUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|min:3|email',
            'password' => 'required|min:3|string'
        ]);

        $response = $this->getRequestData([
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        $_validation_response = $response->json();
        $_valid = $_validation_response['valid'] ?? null;

        if(!$_valid)
            return redirect()->route('logout');

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function getRequestData(array $data)
    {
        $url = config('cps.cps_auth_url');

        if(!$url)
            throw new Exception("Falha ao obter a URL da requição ao CPS. Config:  'cps.cps_auth_url'", 1);

        $http_client = Http::withOptions([
            'debug' => env('# APP_DEBUG', false),
        ]);

        $http_client = $http_client->timeout(config('cps.cps_request_timeout'));

        if(!in_array(config('cps.cps_auth_method'), ['GET', 'POST']))
            throw new Exception("Falha. Método não aceito. São aceitos apenas GET ou POST. Config: 'cps.cps_auth_method'", 1);

        if(config('cps.cps_auth_method') == 'GET')
            return $http_client->asForm()->get($url, $data);

        if(config('cps.cps_auth_method') == 'POST')
            return $http_client->asForm()->post($url, $data);
    }

    public function fakeCpsResponse(Request $request)
    {
        $allowed_emails = [
            'teste@email.com',
            'teste2@email.com',
            'admin@mail.com',
        ];

        $request->validate([
            'email'    => 'required|min:3|email',
            'password' => 'required|min:3|string'
        ]);


        $status_code = in_array($request->input('email'), $allowed_emails) ? 200 : 403;

        return response()->json([
            'valid' => ($status_code == 200 ? true : false)
        ], $status_code);
    }

    public function secondLogin()
    {
        return view('auth.2flogin');
    }
}
