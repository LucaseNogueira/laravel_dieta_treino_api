<?php

use App\Console\Commands\ExclusaoPendenteUsuarios;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ExclusaoPendenteUsuarios::class)
    ->before(function(){
        Log::info('Iniciando a execução do agendamento de exclusão pendente dos usuários');
    })
    ->after(function(){
        Log::info('Finalizado a execução do agendamento de exclusão pendente dos usuários');
    })
    ->daily()->timezone('America/Sao_Paulo')->at('10:35');
