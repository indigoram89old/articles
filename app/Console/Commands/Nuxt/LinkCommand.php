<?php

namespace App\Console\Commands\Nuxt;

use Illuminate\Console\Command;

class LinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nuxt:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link env with nuxtjs';

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
        $this->createSymlink();

        $this->info('Completed!');
    }

    protected function createSymlink()
    {
        if (file_exists(base_path('client/.env'))) {
            return $this->error('The "client/.env" file already exists.');
        }

        $this->laravel->make('files')->link(
            base_path('.env'), base_path('client/.env')
        );

        $this->info('The [.env] file has been linked.');
    }
}
