<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    const FIELD_ID = 'id',
          FIELD_NAME = 'name',
          FIELD_IMG = 'img',
          FIELD_VIDEO_COUNT = 'video_count';

    protected $table = 'models';
}
