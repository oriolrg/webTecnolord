<?php

namespace App\Console\Commands;

use App\Http\Controllers\MeteoController;
use Illuminate\Console\Command;

class UpdateMeteo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:meteo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualitza les dades meteo cada hora';

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
     * @return int
     */
    public function handle()
    {
        $meteo = new MeteoController;
        $meteo->saveDatabaseMeteo();

    }
}
