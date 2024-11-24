<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoModels extends Model
{
    const   FIELD_ID = 'id',
            FIELD_VIDEO_ID = 'video_id',
            FIELD_MODEL_ID = 'model_id';

    protected $table = 'video_models';
}
