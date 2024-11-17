<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Translater  extends Command
{
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
        //AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520
        $url = "https://translate-pa.googleapis.com/v1/translateHtml";
        $header = 'Content-Type:application/json+protobuf; charset=UTF-8';

        $params = json_encode([[["Сегодня хороший день!", "Молодая падчерица провоцирует отчима на страстный секс"], "ru", "en"], "te_lib"]);

        $key = 'X-Goog-Api-Key:AIzaSyATBXajvzQLTDHEQbcpq0Ihe0vWDHmO520';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
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
        var_dump($server_output);
        die();

    }
}
