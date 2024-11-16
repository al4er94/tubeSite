<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Lang\Lang;
use App\Models\VideoContents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class HomePageController extends Controller
{
    public function main()
    {
        return view('public.main', [
            'content' => VideoContents::paginate(self::$defaultPagination)->toArray(),
            'header' => __('Looking now: ')
        ]);
    }

    public function changeLanguage(Request $request)
    {
        $value = $request->get('lang');

        if (!in_array($value, SetLocale::ALL_LANGS)) {
            return Redirect::route('home.public');
        }

        App::setLocale($value);

        return redirect(app()->getLocale());
    }
}
