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
        while (true) {
            $VM = VideoModels::limit(1000)->get()->toArray();
            $vmNew = [];

            $idDrop = [];
            foreach ($VM as $videoModel) {
                $idDrop[] = $videoModel[VideoModels::FIELD_ID];
                $vmNew[$videoModel[VideoModels::FIELD_VIDEO_ID]][] = $videoModel[VideoModels::FIELD_MODEL_ID];
                $vmNew[$videoModel[VideoModels::FIELD_VIDEO_ID]] = array_unique($vmNew[$videoModel[VideoModels::FIELD_VIDEO_ID]]);
            }

            VideoModels::whereIn(VideoModels::FIELD_ID, $idDrop)->delete();

            foreach ($vmNew as $videoId => $models) {
                foreach ($models as $model) {
                    var_dump($videoId . " _ " . $model);
                    VideoModels::insert([
                        VideoModels::FIELD_VIDEO_ID => $videoId,
                        VideoModels::FIELD_MODEL_ID => $model,
                    ]);
                }
            }
        }
    }
}
