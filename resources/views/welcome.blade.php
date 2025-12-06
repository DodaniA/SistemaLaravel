<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SGEM') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Dark mode detection (aplicar antes de pintar la página) -->
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('theme');
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    return;
                }
                if (theme === 'light') {
                    document.documentElement.classList.remove('dark');
                    return;
                }
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <body class="min-h-screen flex items-center justify-center p-6">
        <main class="content-card w-full max-w-2xl mx-auto p-8 flex flex-col items-center gap-6 fade-in">
            <h1 class="text-2xl sm:text-3xl font-semibold text-center text-gradient-orange">Sistema de Gestión de Citas y Expedientes Médicos</h1>
            <x-app-logo-icon class="w-40 h-40 sm:w-48 sm:h-48" />

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="mt-4 btn-medical-primary px-4 py-2 text-sm w-full sm:w-auto text-center">Ir al panel</a>
                @else
                    <div class="flex flex-col sm:flex-row items-center gap-4 mt-4 w-full justify-center">
                            <a href="{{ route('login') }}"  class="btn-medical-secondary px-4 py-2 text-sm w-full sm:w-auto text-center border-2 border-orange-600">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-medical-primary px-4 py-2 text-sm w-full sm:w-auto text-center border-2 border-orange-600">Registrarse</a>
                        @endif
                    </div>
                @endauth
            @endif
        </main>
    </body>
</html>


