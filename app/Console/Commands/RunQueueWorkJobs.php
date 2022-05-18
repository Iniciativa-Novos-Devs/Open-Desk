<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunQueueWorkJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:work-custom-long';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa o queue work com timeout mais longo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->call('queue:work', [
            '--stop-when-empty' => null,
            '--timeout' => 55,
        ]);
    }
}
