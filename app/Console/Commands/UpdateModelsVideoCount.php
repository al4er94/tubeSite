<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Models;
use App\Models\VideoModels;

class UpdateModelsVideoCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-models-video-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        var_dump(123);
    }
}
