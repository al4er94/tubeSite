<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategories extends BaseModel
{
    const   FIELD_ID = 'id',
            FIELD_VIDEO_ID = 'video_id',
            FIELD_CATEGORY_ID = 'category_id';

    protected $table = 'video_categories';
    use HasFactory;
}
