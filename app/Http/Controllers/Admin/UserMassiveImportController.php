<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UserMassiveImportJob;
use App\Models\MassiveImport;
use Illuminate\Http\Request;
use Route;
use Str;

class UserMassiveImportController extends Controller
{
    public static function routes()
    {
        Route::get('massive-import',    [self::class, 'form'])->name('usuarios.massive-import.form');
        Route::post('massive-import',   [self::class, 'uploadFileAndDispatch'])
            ->name('usuarios.massive-import.upload');

        Route::get('massive-import/report',   [self::class, 'importedReportDownload'])
            ->name('usuarios.massive-import.imported_report_download');
    }

    public function __construct()
    {
        $this->middleware(['role:super-admin|admin', 'permission:usuarios-all|usuarios-create|usuarios-read|usuarios-update|usuarios-massive']);
    }

    /**
     * function importedReportDownload
     *
     * @param Request $request
     * @return
     */
    public function importedReportDownload(Request $request)
    {
        $lastImportedReport = storage_path('logs/usuarios_cadastrados.xlsx');

        if (file_exists($lastImportedReport))
        {
            return response()->download($lastImportedReport);
        }
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
        $request->validate([
            'massive_file' => 'required|mimes:xlsx,csv',
        ]);

        $importSheet = $request->file('massive_file');

        $extension = $importSheet->getClientOriginalExtension();

        if (!$extension || !in_array($extension, ['csv', 'xlsx']))
        {
            return redirect()->back()->with(
                'error', __('Error on import file')
            );
        }

        $fileName = Str::random(32)."_user_massive_file.{$extension}";

        $importSheetPath = $importSheet->storeAs(
            'massive_import_files',
            $fileName
        );

        $success = static::createImportAndStartJob(
            $importSheetPath,
            \App\Runners\ImportaUsuariosViaExcel::class,
            'processFile'
        );

        if ($success)
        {
            return redirect()->route('usuarios.index')->with(
                'success',
                __('File uploaded successfully. Wait the finish of import proccess.')
            );
        }

        return redirect()->route('usuarios.massive-import.form')->with(
            'error', __('Error on import file')
        );
    }

    /**
     * function createImportAndStartJob
     *
     * @param Type type
     * @return
     */
    public static function createImportAndStartJob(
        string $importSheetPath,
        string $importerClass,
        string $startClassMethod
    )
    {
        $massive_import = static::storeOnDb(
            $importSheetPath,
            $importerClass,
            $startClassMethod
        );

        if(!$massive_import || !$massive_import instanceof MassiveImport)
        {
            return false;
        }

        UserMassiveImportJob::dispatch($massive_import);

        return true;
    }

    /**
     * function storeOnDb
     *
     * @param string $importSheetPath
     * @return
     */
    protected static function storeOnDb(
        string $importSheetPath,
        string $importerClass,
        string $startClassMethod
    )
    {
        if(!$importSheetPath || !file_exists(storage_path("app/{$importSheetPath}")))
        {
            return false;
        }

        $lastImportedReport = storage_path('logs/usuarios_cadastrados.xlsx');

        if (file_exists($lastImportedReport))
        {
            unlink($lastImportedReport);
        }

        return MassiveImport::create([
            'file_path'          => $importSheetPath,
            'importer_class'     => $importerClass,
            'start_class_method' => $startClassMethod,
            'started_at'         => null,
            'finished_at'        => null,
            'report_file'        => null,
        ]);
    }
}
