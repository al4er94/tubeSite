<?php

namespace App\Http\Controllers;

use App\Http\Enums\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class LocaleController extends Controller
{
    public function languages(): JsonResponse
    {
        return response()->json(Language::toArray());
    }

    public function translations(string $locale): JsonResponse
    {
        Language::from($locale); // бросит ValueError если локаль неизвестна

        $translations = require base_path("lang/{$locale}/common.php");

        return response()->json(Arr::dot($translations));
    }
}
