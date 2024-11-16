<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    const LANG_EN = 'en';
    const LANG_DE = 'de';
    const LANG_RU = 'ru';


    const ALL_LANGS = [
        self::LANG_EN,
        self::LANG_DE,
        self::LANG_RU,
    ];

    public function handle($request, Closure $next)
    {
        app()->setLocale($request->segment(1));
        return $next($request);
    }
}
