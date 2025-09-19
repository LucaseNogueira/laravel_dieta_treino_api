<?php

namespace App\Listeners;

use App\Events\AfterCadastroUsuario;
use App\Jobs\ConfirmarEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarEmailConfirmacaoUsuario
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AfterCadastroUsuario $event): void
    {
        ConfirmarEmailJob::dispatch($event->usuario);
    }
}
