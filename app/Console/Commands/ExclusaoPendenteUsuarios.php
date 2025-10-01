<?php

namespace App\Console\Commands;

use App\Enums\UsuarioStatus;
use App\Http\Services\UsuarioService;
use App\Models\Usuario;
use Illuminate\Console\Command;

class ExclusaoPendenteUsuarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:exclusao-pendente-usuarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exclui todos os usuários com status igual a Exclusão Pendente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new UsuarioService();

        $ids = $service->model()::where('status', UsuarioStatus::EXCLUSAO_PENDENTE)->pluck('id')->toArray();

        $service->excluirUsuario($ids);
    }
}
