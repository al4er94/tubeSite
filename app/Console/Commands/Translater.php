<?php

namespace App\Console\Commands;

use App\Models\VideoContents;
use Illuminate\Console\Command;
use App\Models\Categories;

class Translater  extends Command
{
    const FIELD_NAME_TO = 'name_de';
    const FIELD_NAME_FROM = 'name_ru';
    const LANG_TO = 'de';
    const LANG_FROM = 'ru';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:translater';

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
        $this->translateVideos();
    }

    protected function translateCategories()
    {
        //AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520

        $translate = [];
        $categoryesIds = [];
        $i = 0;
        foreach (Categories::all() as $category ) {
            if ($category->{self::FIELD_NAME_TO} != '') {
                continue;
            }

            $name = $category->{self::FIELD_NAME_FROM};
            $translate[] = $name;
            $categoryesIds[$i] = $category;
            $i++;
        }

        if (!empty($translate)) {
            $url = "https://translate-pa.googleapis.com/v1/translateHtml";
            $header = 'Content-Type:application/json+protobuf; charset=UTF-8';

            $params = json_encode([[$translate, self::LANG_FROM, self::LANG_TO], "te_lib"]);

            $key = 'X-Goog-Api-Key:AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                $header,
                $key
            ]);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            $server_output = json_decode($server_output)[0];

            var_dump($server_output);

            foreach ($categoryesIds as $i => $category) {
                $category->{self::FIELD_NAME_TO} = html_entity_decode($server_output[$i]);
                $category->update();
            }
        }
    }

    protected function translateVideos()
    {
        //AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520

        $translate = [];
        $contentIds = [];
        $i = 0;
        foreach (VideoContents::all()->chunk(50) as $chunk) {
            foreach ($chunk as $content) {
                if ($content->{self::FIELD_NAME_TO} != '') {
                    continue;
                }

                if ($content->{self::FIELD_NAME_FROM} == '') {
                    continue;
                }

                $name = $content->{self::FIELD_NAME_FROM};
                $translate[] = $name;
                $contentIds[$i] = $content;
                $i++;
            }
        }

        if (!empty($translate)) {
            $url = "https://translate-pa.googleapis.com/v1/translateHtml";
            $header = 'Content-Type:application/json+protobuf; charset=UTF-8';

            $params = json_encode([[$translate, self::LANG_FROM, self::LANG_TO], "te_lib"]);

            $key = 'X-Goog-Api-Key:AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                $header,
                $key
            ]);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);

            $server_output = json_decode($server_output)[0];

            var_dump($server_output);

            foreach ($contentIds as $i => $content) {
                $content->{self::FIELD_NAME_TO} = html_entity_decode($server_output[$i]);
                $content->update();
            }
        }

    }
}
