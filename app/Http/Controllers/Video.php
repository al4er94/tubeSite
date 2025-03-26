<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\VideoContents;
use App\Models\Categories;
use App\Models\VideoCategories;

class Video extends Controller
{
    public function getVideo($id){
        $video = VideoContents::find($id)->toArray();
        $video[VideoContents::FIELD_URL] = Config::get('app.url') . "/" . $video[VideoContents::FIELD_URL];


        return view('video', [
            'video' => $video
        ]);
    }

    public function getVideoById($lang = null, $id, Request $request){
        $video = VideoContents::find($id)->toArray();
        $video[VideoContents::FIELD_PREVIEW_URL] = HomePageController::getEmbedDomen() . $video[VideoContents::FIELD_PREVIEW_URL];

        $categories = Categories::from(Categories::getTableName() . " as c")
            ->leftJoin(VideoCategories::getTableName() . ' as vc',
                'c.' . Categories::FIELD_ID,
                '=',
                'vc.' . VideoCategories::FIELD_CATEGORY_ID)
            ->where('vc.' . VideoCategories::FIELD_VIDEO_ID, '=', $id)
            ->get(['c.' . Categories::FIELD_ID . ' as ' . Categories::FIELD_ID, 'c.' . Categories::getNameByLocale() . ' as ' . Categories::FIELD_NAME])
            ->toArray();

        return view('public.video', [
            'video' => $video,
            'tkn' => self::generateVideoToken($request),
            'categories' => $categories
        ]);
    }

    public static function generateVideoToken(Request $request)
    {
        $json = json_encode([
            'time' => time(),
            'ua' => $request->server('HTTP_USER_AGENT')
        ]);

        return base64_encode ($json);
    }
}
