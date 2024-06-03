<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') . (!empty($page->title) ? (' - ' . $page->title) : '') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/filament/admin/theme.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
