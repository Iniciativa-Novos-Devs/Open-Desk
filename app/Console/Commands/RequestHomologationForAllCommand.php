<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RequestHomologationForAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chamados:homologation-request-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mail para os donos de chamados que ainda não homologaram.';

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
        info('Iniciando o envio de e-mails para os donos de chamados que ainda não homologaram.');
        \App\Http\Controllers\HomologacaoController::requestHomologationForAll();
    }
}
