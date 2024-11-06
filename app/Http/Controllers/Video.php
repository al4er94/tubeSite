<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use Illuminate\Support\Facades\Config;
class Video extends Controller
{
    public function getVideo($id){
        $video = VideoContents::find($id)->toArray();
        $video[VideoContents::FIELD_URL] = Config::get('app.url') . "/" . $video[VideoContents::FIELD_URL];


        return view('video', [
            'video' => $video
        ]);
    }
}
