<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <link type="image/x-icon" rel="shortcut icon" href="assets/img/icon/logo_2_2.png">
    <link type="image/png" sizes="16x16" rel="icon" href="assets/img/icon/logo_2_2_16.png">
    <link type="image/png" sizes="32x32" rel="icon" href="assets/img/icon/logo_2_2_32.png">
    <link type="image/png" sizes="96x96" rel="icon" href="assets/img/icon/logo_2_2_96.png">
    <link type="image/png" sizes="120x120" rel="icon" href="assets/img/icon/logo_2_2_120.png">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('auth.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>
