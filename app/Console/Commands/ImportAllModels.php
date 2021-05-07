<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportAllModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:import_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all data in tnt search index for fast model and site wide search';

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
        mkdir(storage_path('index'));
        \Artisan::call("scout:import App\\\Models\\\Scan");
        \Artisan::call("scout:import App\\\Models\\\Results");
        \Artisan::call("scout:import App\\\Models\\\Categories");
        \Artisan::call("scout:import App\\\Models\\\Questions");
        \Artisan::call("scout:import App\\\Models\\\User");
        return 0;
    }
}
