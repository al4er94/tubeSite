<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(){
        return view('main', [
            'content' => VideoContents::paginate(self::$defaultPagination)->toArray()
        ]);
    }
}
