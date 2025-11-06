<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    @vite([
        'resources/css/sneat-assets/core.css', 
        'resources/css/sneat-assets/theme-default.css',
        // Panggil CSS tambahan Sneat di sini
        'resources/css/app.css' // Jika ada CSS kustom Anda
    ])
    
    @vite(['resources/js/sneat-assets/helpers.js'])
    
    @yield('styles')
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            @include('layouts.partials.sidebar') 

            <div class="layout-page">
                
                @include('layouts.partials.navbar') 

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    @include('layouts.partials.footer') 

                    <div class="content-backdrop fade"></div>
                </div>
                </div>
            </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    @vite([
        'resources/js/sneat-assets/config.js',
        'resources/js/sneat-assets/menu.js',
        'resources/js/sneat-assets/main.js',
        'resources/js/app.js' // JS default Laravel
    ])

    @yield('scripts')
</body>
</html>