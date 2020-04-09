<?php

namespace App\Console\Commands\Articles;

use App\Import\Facades\Import;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import articles from json file.';

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
        $file = $this->argument('file');

        $password = Import::config('password');

        Import::start(compact('file', 'password'));

        $this->info('Completed');
    }
}
