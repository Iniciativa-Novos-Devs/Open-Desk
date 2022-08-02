<?php

namespace App\Listeners;

use App\Events\ChamadoEmHomologacaoEvent;
use App\Http\Controllers\Admin\HomologacaoController;

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
        HomologacaoController::sendHomologationRequestEmailToUser($event->chamado);
    }
}
