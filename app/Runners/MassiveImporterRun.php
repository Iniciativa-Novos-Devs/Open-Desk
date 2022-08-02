<?php

namespace App\Runners;

use App\Models\MassiveImport;

class MassiveImporterRun
{
    /**
     * processImport method
     */
    public static function processImport(MassiveImport $massiveImport)
    {
        if ($massiveImport->finished_at) {
            return;
        }

        $importerFilePath = $massiveImport->file_path ?? '';
        $importerFileFullPath = storage_path("app/{$importerFilePath}");

        if (
            ! $importerFileFullPath ||
            ! is_string($importerFileFullPath) ||
            ! file_exists($importerFileFullPath)
        ) {
            $massiveImport->update([
                'success' => false,
                'finished_at' => now(),
                'report_file' => null,
            ]);

            return;
        }

        $massiveImport->started_at = now();

        $importerClass = $massiveImport->importer_class ?? '';
        $startClassMethod = $massiveImport->start_class_method ?? '';

        $return = (new $importerClass())->$startClassMethod($importerFileFullPath);

        $success = (bool) ($return['success'] ?? null);
        $reportFile = $return['report_file'] ?? null;

        $massiveImport->update([
            'success' => $success,
            'finished_at' => now(),
            'report_file' => $reportFile,
        ]);
    }
}
