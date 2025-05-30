<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Lang\Lang;
use App\Models\VideoContents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomePageController extends Controller
{
    public function main()
    {
        $videos = VideoContents::orderBy(VideoContents::FIELD_ID, 'asc')->paginate(self::$defaultPagination)->toArray();

        return view('public.main', [
            'content' => $videos,
            'title' => __('public.new') . " - " . __('public.leakedGirls'),
            'header' => __('public.new'),
            'article' => __('public.articleMain'),
            'description' => __('public.new') . " - " . __('public.onlineFree'),
        ]);
    }

    public function changeLanguage(Request $request)
    {
        $value = $request->get('lang');

        if (!in_array($value, SetLocale::ALL_LANGS)) {
            return Redirect::route('home.public');
        }

        App::setLocale($value);
        $request->session()->put('lang', $value);

        return redirect(app()->getLocale());
    }

    public static function getEmbedDomen() : string
    {
        return SetLocale::EN_DOMAIN;
    }
}
