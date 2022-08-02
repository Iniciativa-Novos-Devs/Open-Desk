<?php

namespace App\Jobs;

use App\Models\MassiveImport;
use App\Runners\MassiveImporterRun;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserMassiveImportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ?MassiveImport $massive_import;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(?MassiveImport $massive_import = null)
    {
        $this->massive_import = $massive_import;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->massive_import || ! $this->massive_import instanceof MassiveImport) {
            return;
        }

        MassiveImporterRun::processImport($this->massive_import);
    }
}
