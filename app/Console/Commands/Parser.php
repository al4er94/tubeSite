<?php

namespace App\Console\Commands;

use App\Http\Controllers\HomePageController;
use Illuminate\Console\Command;
use App\Models\VideoContents;
use App\Models\Categories;
use App\Models\VideoCategories;
use App\Models\Models;
use App\Models\VideoModels;

class Parser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser';

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
        $lastInsertedIds = VideoContents::all([VideoContents::FIELD_ID, VideoContents::FIELD_VK_ID])
            ->pluck(VideoContents::FIELD_ID, VideoContents::FIELD_VK_ID)->toArray();

        for ($i= 190045; $i < 190070; $i++) {
            $categoriesDb = Categories::all([Categories::FIELD_ID, Categories::FIELD_NAME_RU])
                ->pluck(Categories::FIELD_ID, Categories::FIELD_NAME_RU)->toArray();

            $modelsDb = Models::all([Models::FIELD_ID, Models::FIELD_NAME])->pluck(Models::FIELD_ID, Models::FIELD_NAME)->toArray();

            sleep(8);
            $id = $i;

            if (isset($lastInsertedIds[$id])) {
                var_dump('video id ' . $id . ' exist');

                continue;
            }

            $endpoint = HomePageController::getEmbedDomen() . "/video/$id";

            $client = new \GuzzleHttp\Client();


            try {
                $response = $client->request('GET', $endpoint, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                    ]
                ]);
            }catch ( \Exception\RequestException $exception) {
                var_dump("err: " . $exception->getMessage());

                continue;
            }

            $views = rand(200, 100000);
            $likes = rand(1, (int)$views / 2);


            $statusCode = $response->getStatusCode();
            $content = $response->getBody();

            if ($statusCode != 200) {
                var_dump("err code: " . $statusCode);

                continue;
            }

            $contentStr = $content->getContents();

            $matches = [];
            $find = preg_match("/<title>(.+)<\/title>/", $contentStr, $matches);

            if (!$find) {
                var_dump("can't find title");

                continue;
            }

            $name = $matches[1];

            $name = str_replace(' - порно видео', '', $name);

            $matches = [];
            $find2 = preg_match('/<div class="info-content">(.+?)<\/div>/im', $contentStr, $matches);

            if (!$find2) {
                var_dump("can't parse ");

                continue;
            }

            $matchesInfo = [];
            preg_match_all('/<a.+?> (.+?)<\/a>/im', $matches[1], $matchesInfo);

            $categories = [];
            $modelsAll = [];

            foreach ($matchesInfo[1] as $category) {
                $position = strpos($category, 'span');
                if ($position === false) {
                    $categories[] = trim($category);

                    continue;
                }

                $models = [];
                preg_match('/<span.+?> (.+?)<\/span>/im', $category, $models);


                $model = str_replace('<i class="icon icon-top_models1">', "", $models[1]);
                $model = str_replace('</i>', "", $model);
                $modelsAll[] = trim($model);
            }

            $matches = [];
            $find5 = preg_match('/var\sflashvars\s=\s{(.+?)};/im', $contentStr, $matches);

            if (!$find5) {
                var_dump("can't parse img " . $id);

                continue;
            }

            $strArr = explode(',', $matches[1]);
            $url = '';
            foreach ($strArr as $item) {
                $item = trim($item);
                $itemArr = explode(': ', $item);

                if ($itemArr[0] == 'preview_url2') {
                    $url = str_replace("'", '', $itemArr[1]);
                }
            }

            $urlArr = parse_url($url);

            $insertCategories = [];
            foreach ($categories as $categoryName) {
                if (isset($categoriesDb[$categoryName])) {
                    continue;
                }

                $insertCategories[] = [
                    Categories::FIELD_NAME_RU => $categoryName
                ];
            }

            if (!empty($insertCategories)) {
                Categories::insert($insertCategories);
            }

            $videoCategoriesFresh = Categories::whereIn(Categories::FIELD_NAME_RU, $categories)->get(Categories::FIELD_ID)->toArray();

            $insertVideo = [
                VideoContents::FIELD_VK_ID => $id,
                VideoContents::FIELD_NAME_RU => $name,
                VideoContents::FIELD_LIKES => $likes,
                VideoContents::FIELD_VIEWS => $views,
                VideoContents::FIELD_PREVIEW_URL => $urlArr['path'],
                VideoContents::FIELD_URL => '/embed/' . $id,
            ];

            $videoId = VideoContents::insertGetId($insertVideo);

            $linkCategories = [];

            foreach ($videoCategoriesFresh as $categoriesFresh) {
                $linkCategories[] = [
                    VideoCategories::FIELD_VIDEO_ID => $videoId,
                    VideoCategories::FIELD_CATEGORY_ID => $categoriesFresh[Categories::FIELD_ID]
                ];
            }

            VideoCategories::insert($linkCategories);

            $insertModels = [];
            foreach ($modelsAll as $modelName) {
                if (isset($modelsDb[$modelName])) {
                    continue;
                }

                $insertModels[] = [
                    Models::FIELD_NAME => $modelName
                ];
            }

            if (!empty($insertModels)) {
                Models::insert($insertModels);
            }

            $videoModelsFresh = Models::whereIn(Models::FIELD_NAME, $modelsAll)->get(Models::FIELD_ID)->toArray();

            foreach ($videoModelsFresh as $modelsFresh) {
                $linkModels[] = [
                    VideoModels::FIELD_VIDEO_ID => $videoId,
                    VideoModels::FIELD_MODEL_ID => $modelsFresh[Models::FIELD_ID]
                ];
            }

            VideoModels::insert($linkModels);
        }

    }
}
