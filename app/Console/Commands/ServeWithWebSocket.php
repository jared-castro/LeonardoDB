<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeWithWebSocket extends Command
{
    protected $signature = 'serve:all';
    protected $description = 'Inicia Laravel y el servidor WebSocket simultáneamente';

    public function handle()
    {
        $laravelProcess = new Process(['php', 'artisan', 'serve']);
        $laravelProcess->setTimeout(null);
        $laravelProcess->start();

        $nodeProcess = new Process(['node', 'chatServer.js'], base_path('server'));
        $nodeProcess->setTimeout(null);
        $nodeProcess->start();

        $this->info('Servidor Laravel iniciado en http://127.0.0.1:8000');
        $this->info('Servidor WebSocket iniciado en ws://localhost:8080');

        while ($laravelProcess->isRunning() || $nodeProcess->isRunning()) {
            echo $laravelProcess->getIncrementalOutput();
            echo $nodeProcess->getIncrementalOutput();
            usleep(100000);
        }

        return 0;
    }
}