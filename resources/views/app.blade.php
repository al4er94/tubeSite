<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title inertia>{{ config('app.name') }}</title>
    @foreach(\App\Http\Enums\Language::cases() as $lang)
        <link rel="alternate" hreflang="{{ $lang->value }}" href="{{ url('/' . $lang->value) }}"/>
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('/' . config('app.locale')) }}"/>
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
