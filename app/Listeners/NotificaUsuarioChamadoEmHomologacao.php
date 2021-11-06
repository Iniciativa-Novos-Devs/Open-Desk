<?php

namespace App\Listeners;

use App\Events\ChamadoEmHomologacaoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificaUsuarioChamadoEmHomologacao
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChamadoEmHomologacaoEvent  $event
     * @return void
     */
    public function handle(ChamadoEmHomologacaoEvent $event)
    {
        \App\Http\Controllers\HomologacaoController::sendHomologationRequestEmailToUser($event->chamado);
    }
}