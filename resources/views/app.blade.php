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
    @if(config('services.google.gtag_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.gtag_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            {{-- send_page_view отключен: Inertia — SPA, первый и все последующие page_view шлём вручную из app.js на каждый переход --}}
            gtag('config', '{{ config('services.google.gtag_id') }}', { send_page_view: false });
            @if(config('services.google.ads_id'))
                gtag('config', '{{ config('services.google.ads_id') }}');
            @endif
        </script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
@inertia
</body>
</html>
