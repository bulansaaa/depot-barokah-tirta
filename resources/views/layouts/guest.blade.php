<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts & Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        </style>
    </head>
    <body class="bg-background font-body-md text-on-surface antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface/50 backdrop-blur-sm">
            <div class="mb-8 flex flex-col items-center gap-2">
                <div class="h-16 w-16 rounded-2xl bg-primary-container flex items-center justify-center text-on-primary-container shadow-sm border border-outline-variant/20">
                    <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">water_drop</span>
                </div>
                <h1 class="font-headline-md text-headline-md font-bold text-primary">Barokah Tirta</h1>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-surface-container-lowest border border-outline-variant/30 shadow-xl sm:rounded-2xl relative overflow-hidden">
                <!-- Decorative top accent -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-primary"></div>
                
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-on-surface-variant font-label-md text-label-md">
                &copy; {{ date('Y') }} Depot Barokah Tirta. All rights reserved.
            </p>
        </div>
    </body>
</html>
