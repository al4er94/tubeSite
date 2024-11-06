<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Categories extends BaseModel
{
    const   FIELD_ID = 'id',
            FIELD_NAME = 'name',
            FIELD_DESCRIPTION = 'description',
            FIELD_IMG_URL = 'img_url';


    protected $table = 'categories';
    use HasFactory;
}
