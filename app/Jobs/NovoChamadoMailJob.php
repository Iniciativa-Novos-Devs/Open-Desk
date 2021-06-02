<?php

namespace App\Jobs;

use App\Http\Controllers\ChamadoController;
use App\Models\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NovoChamadoMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chamado;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ChamadoController::enviaEmailNovoChamado($this->chamado);
    }
}
