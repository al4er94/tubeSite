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

    const EN_DOMAIN = "https://xxxi.porn";
    const RU_DOMAIN = "https://x17.rusoska.mobi";
    const DE_DOMAIN = "https://de.xxxi.porn/";

    public function handle($request, Closure $next)
    {
        app()->setLocale($request->segment(1));
        switch ($request->segment(1)) {
            case self::LANG_RU:
                $request->session()->put("embedDomain", self::RU_DOMAIN);
                break;
            case self::LANG_DE:
                $request->session()->put("embedDomain", self::DE_DOMAIN);
                break;
            default:
                $request->session()->put("embedDomain", self::EN_DOMAIN);
                break;
        }
        return $next($request);
    }
}
