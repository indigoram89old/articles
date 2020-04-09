<?php

namespace App\Console\Commands\Nuxt;

use App\Nuxt\Nuxt;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class VersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nuxt:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update nuxt version';

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
        Nuxt::setVersion(Str::random(33));

        $this->info('Completed!');
    }
}
