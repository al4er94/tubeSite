<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    const FIELD_ID = 'id',
          FIELD_NAME = 'name';

    protected $table = 'models';
}
