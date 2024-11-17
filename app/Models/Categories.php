<?php

namespace App\Models;

use App\Http\Middleware\SetLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Categories extends BaseModel
{
    const   FIELD_ID = 'id',
            FIELD_NAME = 'name',
            FIELD_NAME_RU = 'name_ru',
            FIELD_NAME_DE = 'name_de',
            FIELD_DESCRIPTION = 'description',
            FIELD_DESCRIPTION_RU = 'description_ru',
            FIELD_DESCRIPTION_DE = 'description_de',
            FIELD_IMG_URL = 'img_url';


    protected $fillable = [self::FIELD_NAME];

    protected $table = 'categories';
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
