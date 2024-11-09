<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function main()
    {
        return view('public.main', [
            'content' => VideoContents::paginate(self::$defaultPagination)->toArray()
        ]);
    }
}
