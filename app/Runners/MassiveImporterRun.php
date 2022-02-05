<?php

namespace App\Runners;

use App\Models\MassiveImport;

class MassiveImporterRun
{
    /**
     * processImport method
     *
     */
    public static function processImport(MassiveImport $massiveImport)
    {
        if($massiveImport->finished_at)
        {
            return;
        }

        $importerFilePath   = $massiveImport->file_path          ?? '';

        if (!$importerFilePath || !file_exists($importerFilePath))
        {
            $massiveImport->update([
                'success'     => false,
                'finished_at' => now(),
                'report_file' => null,
            ]);
            return;
        }

        $massiveImport->started_at = now();

        $importerClass      = $massiveImport->importer_class     ?? '';
        $startClassMethod   = $massiveImport->start_class_method ?? '';

        $return = (new $importerClass())->$startClassMethod($importerFilePath);

        $success    = !! ($return['success'] ?? null);
        $reportFile = $return['report_file'] ?? null;

        $massiveImport->update([
            'success'     => $success,
            'finished_at' => now(),
            'report_file' => $reportFile,
        ]);
    }
}
