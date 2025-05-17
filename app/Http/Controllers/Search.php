<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use Illuminate\Http\Request;

class Search extends Controller
{
    public function search(Request $request, $locale = null, $searchVal = null)
    {
        if ($request->isMethod($request::METHOD_POST) && $request->session()->token() !== $request->post('_token')) {
            return redirect()->route('home.public');
        }

        if ($request->isMethod($request::METHOD_POST)) {
            $searchValDef = $request->post('search');
        } else {
          $searchValDef = $searchVal;
        }

        $searchVal = strtolower(strip_tags(trim($searchValDef)));
        $searchVal = preg_replace('/([;.,!?:-])/', ' ', $searchVal);
        $searchArr = explode(' ', $searchVal);

        $vc = VideoContents::where(function ($query) use ($searchArr) {
            foreach ($searchArr as $i => $searchItem) {
                if ($i == 0) {
                    $query->where(VideoContents::getNameByLocale(), 'like', '%' . $searchItem . '%');
                } else {
                    $query->orWhere(VideoContents::getNameByLocale(), 'like', '%' . $searchItem . '%');
                }
                $query  ->orWhere(VideoContents::getNameByLocale(), 'like', '%' . $searchItem )
                        ->orWhere(VideoContents::getNameByLocale(), 'like', '' . $searchItem . '%')
                        ->orWhere(VideoContents::FIELD_DESCRIPTION, 'like', '% '. $searchItem . '%');
            }
        })->paginate(self::$defaultPagination);

        if ($request->isMethod($request::METHOD_POST)) {
            return redirect()->route('searchView', [
                'locale' => app()->getLocale(),
                'searchVal' => implode('-', $searchArr)
            ]);
        }

        return view('public.main', [
            'content' => $vc->toArray(),
            'searchVal' => str_replace('-', ' ', $searchValDef),
            'title' => str_replace('-', ' ', $searchValDef),
            'header' => str_replace('-', ' ', $searchValDef),
        ]);
    }
}
