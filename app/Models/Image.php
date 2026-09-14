<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $path
 * @property string $slug
 * @property int $views
 * @property int $likes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Image extends Model
{
    const FIELD_IS = 'id';
    const FIELD_PATH = 'path';
    const FIELD_SLUG = 'slug';
    const FIELD_VIEWS = 'views';
    const FIELD_LIKES = 'likes';

    protected $fillable = ['legacy_id', 'vk_id', 'path', 'slug', 'link', 'views', 'likes'];

    public function translations(): HasMany
    {
        return $this->hasMany(ImageTranslation::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function similar(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'image_similar', 'image_id', 'similar_image_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }

    public function translation(string $locale = null): ?ImageTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', config('app.fallback_locale'));
    }
}
