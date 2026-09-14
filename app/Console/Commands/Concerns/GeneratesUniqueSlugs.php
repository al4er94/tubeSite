<?php

namespace App\Console\Commands\Concerns;

trait GeneratesUniqueSlugs
{
    /**
     * @param class-string<\Illuminate\Database\Eloquent\Model> $modelClass
     */
    private function uniqueSlug(string $modelClass, string $base): string
    {
        $slug = $base;
        $i = 1;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = "{$base}-" . $i++;
        }

        return $slug;
    }
}
