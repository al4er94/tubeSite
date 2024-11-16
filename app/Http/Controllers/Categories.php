<?php

namespace App\Http\Controllers;

use App\Models\VideoContents;
use App\Models\VideoCategories;
use Illuminate\Http\Request;
use App\Models\Categories as CategoriesModel;
use Illuminate\Support\Facades\Config;

class Categories extends Controller
{
    public function getAllCategories()
    {
        $categories = CategoriesModel::all();

        foreach ($categories as $category) {
            if (!$category->img_url) {
                $videosIds = VideoContents::from(VideoContents::getTableName() . " as content")
                    ->leftJoin(VideoCategories::getTableName() . ' as category',
                        'content.' . VideoContents::FIELD_ID,
                        '=',
                        'category.' . VideoCategories::FIELD_VIDEO_ID)
                    ->where('category.' . VideoCategories::FIELD_CATEGORY_ID, '=', $category->id)
                    ->get(['content.' . VideoContents::FIELD_PREVIEW_URL . ' as ' . VideoContents::FIELD_PREVIEW_URL])
                    ->pluck(VideoContents::FIELD_PREVIEW_URL)->toArray();

                $category->img_url = $videosIds[array_rand($videosIds)];
            }
        }

        return view('public.categories', [
            'categories' => $categories
        ]);
    }


    public function getVideosByCategories(string $lang = null, $id)
    {
        $videosIds = VideoContents::from(VideoContents::getTableName() . " as content")
        ->leftJoin(VideoCategories::getTableName() . ' as category',
            'content.' . VideoContents::FIELD_ID,
            '=',
            'category.' . VideoCategories::FIELD_VIDEO_ID)
        ->where('category.' . VideoCategories::FIELD_CATEGORY_ID, '=', $id)
        ->get(['content.' . VideoContents::FIELD_ID . ' as ' . VideoContents::FIELD_ID])
        ->pluck(VideoContents::FIELD_ID)->toArray();

        return view('public.main', [
            'content' => VideoContents::whereIn(VideoContents::FIELD_ID, $videosIds)
                ->paginate(self::$defaultPagination)
                ->toArray()
        ]);
    }

    public function getMostViewVideos()
    {
        return view('public.main', [
            'content' => VideoContents::orderBy(VideoContents::FIELD_VIEWS, 'desc')->paginate(self::$defaultPagination)->toArray(),
            'header' => __('Most view: ')
        ]);
    }

    public function getTopRatedVideos()
    {
        return view('public.main', [
            'content' => VideoContents::orderBy(VideoContents::FIELD_LIKES, 'desc')->paginate(self::$defaultPagination) ->toArray(),
            'header' => __('Top rated: ')
        ]);
    }
}
