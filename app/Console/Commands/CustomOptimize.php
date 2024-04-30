<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\OptimizeCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CustomOptimize extends OptimizeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void {
        $this->call('icons:cache');
        $this->call('filament:cache-components');
        parent::handle();
        $process = Process::fromShellCommandline('npm run build');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        echo $process->getOutput();
        $this->call('filament:assets');
    }
}
