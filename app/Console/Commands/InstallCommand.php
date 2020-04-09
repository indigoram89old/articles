<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\ConfirmableTrait;

class InstallCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

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
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $this->importArticles();

        $this->installNuxt();

        $this->info('Completed!');
    }

    protected function importArticles()
    {
        $this->info('Articles...');

        Artisan::call('articles:import https://ucarecdn.com/a0d70122-fe8a-4bad-ba7c-a138392e41e0/');
    }

    protected function installNuxt()
    {
        $this->info('Nuxtjs...');

        Artisan::call('nuxt:link');
    }
}
