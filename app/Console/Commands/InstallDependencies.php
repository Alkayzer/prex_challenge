<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class InstallDependencies extends Command
{
    protected $signature = 'app:install';
    protected $description = 'Setup Laravel Passport';

    public function handle()
    {
        $this->info('Installing Laravel Passport keys...');
        exec('yes | php artisan passport:install --force');

        $this->info('Executing PHPUnit tests...');
        $process = new Process(['vendor/bin/phpunit']);
        $process->setWorkingDirectory(base_path());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        return Command::SUCCESS;
    }
}
