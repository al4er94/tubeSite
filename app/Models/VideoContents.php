<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoContents extends BaseModel
{
    const   FIELD_ID = 'id',
            FIELD_VK_ID = 'vkId',
            FIELD_NAME = 'name',
            FIELD_DESCRIPTION = 'description',
            FIELD_URL = 'url',
            FIELD_PREVIEW_URL = 'previewUrl',
            FIELD_VIEWS = 'views',
            FIELD_LIKES = 'likes',
            FIELD_CREATED_AT = 'created_at',
            FIELD_UPDATED_AT = 'updated_at';

    protected $table = 'video_contents';


    use HasFactory;
}
