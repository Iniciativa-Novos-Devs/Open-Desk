<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class UserMassiveImportController extends Controller
{
    public static function routes()
    {
        Route::get('massive-import',    [self::class, 'form'])->name('users.massive-import.form');
        Route::post('massive-import',   [self::class, 'uploadFileAndDispatch'])->name('users.massive-import.upload');
    }

    public function __construct()
    {
        $this->middleware(['role:super-admin|admin', 'permission:usuarios-all|usuarios-create|usuarios-read|usuarios-update|usuarios-massive']);
    }

    /**
     * function form
     *
     * @param Request $request
     * @return
     */
    public function form(Request $request)
    {
        return view('admin.user_massive_import.form');
    }

    /**
     * function uploadFileAndDispatch
     *
     * @param Request $request
     * @return
     */
    public function uploadFileAndDispatch(Request $request)
    {
        var_dump('/**
         * TODO:
         * - validar o arquivo
         * - validar o tamanho do arquivo
         * - validar o formato do arquivo
         * - Armazenar o arquivo no storage e criar referencia no banco
         * - Disparar o processo de importação
         * - Criar job e script que importa os dados
         */');
        dd([$request->all(),__FILE__.':'.__LINE__]);
    }
}
