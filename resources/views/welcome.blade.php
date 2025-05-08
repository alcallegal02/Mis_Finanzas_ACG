<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            body { font-family: 'Figtree', sans-serif; }
            .fixed-top-right { position: fixed; top: 1rem; right: 1rem; }
            .auth-link { margin-left: 1rem; font-weight: 600; text-decoration: none; color: #6b7280; } /* Tailwind text-gray-500 */
            .auth-link:hover { color: #111827; } /* Tailwind text-gray-900 */
            .main-content { display: flex; justify-content: center; align-items: center; min-height: 100vh; }
            h1 { font-size: 2.25rem; /* Tailwind text-4xl */ }
        </style>
    </head>
    <body class="antialiased">
        @if (Route::has('login'))
            <div class="fixed-top-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="auth-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="auth-link">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="auth-link">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="main-content">
            <div>
                <h1>Mis Finanzas ACG</h1>
            </div>
        </div>
    </body>
</html>