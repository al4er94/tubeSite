<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageTranslation extends Model
{
    protected $fillable = ['image_id', 'locale', 'title', 'description', 'keywords'];

    protected $casts = [
        'keywords' => 'array',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
