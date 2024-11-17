<?php

namespace App\Models;

use App\Http\Middleware\SetLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContents extends BaseModel
{
    const   FIELD_ID = 'id',
            FIELD_VK_ID = 'vkId',
            FIELD_NAME = 'name',
            FIELD_NAME_RU = 'name_ru',
            FIELD_NAME_DE = 'name_de',
            FIELD_DESCRIPTION = 'description',
            FIELD_DESCRIPTION_RU = 'description_ru',
            FIELD_DESCRIPTION_DE = 'description_de',
            FIELD_URL = 'url',
            FIELD_PREVIEW_URL = 'previewUrl',
            FIELD_VIEWS = 'views',
            FIELD_LIKES = 'likes',
            FIELD_CREATED_AT = 'created_at',
            FIELD_UPDATED_AT = 'updated_at';

    protected $table = 'video_contents';


    use HasFactory;

    public static function getNameByLocale() : string
    {
        switch (app()->getLocale()){
            case SetLocale::LANG_RU:
                return self::FIELD_NAME_RU;
            case SetLocale::LANG_DE:
                return self::FIELD_NAME_DE;
            default:
                return self::FIELD_NAME;
        }
    }

    public static function getDescriptionByLocale() : string
    {
        switch (app()->getLocale()){
            case SetLocale::LANG_RU:
                return self::FIELD_NAME_RU;
            case SetLocale::LANG_DE:
                return self::FIELD_NAME_DE;
            default:
                return self::FIELD_NAME;
        }
    }
}
