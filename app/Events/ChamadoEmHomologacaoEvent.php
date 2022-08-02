<?php

namespace App\Events;

use App\Models\Chamado;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChamadoEmHomologacaoEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Chamado $chamado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('channel-name');
    }
}
