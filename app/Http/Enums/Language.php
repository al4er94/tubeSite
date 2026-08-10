<?php

namespace App\Http\Enums;

enum Language: string
{
    case RU = 'ru';
    case EN = 'en';
    case DE = 'de';
    case FR = 'fr';

    public function label(): string
    {
        return match($this) {
            Language::RU => 'Русский',
            Language::EN => 'English',
            Language::DE => 'Deutsch',
            Language::FR => 'Français',
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($lang) => [
            'code' => $lang->value,
            'name' => $lang->label(),
        ], self::cases());
    }
}
