<!DOCTYPE html>
<html lang="pt" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistur Angola') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: { 50:'#fff7ed',100:'#ffedd5',200:'#fed7aa',300:'#fdba74',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c' }
                        }
                    }
                }
            }
        </script>
        <link rel="icon" type="image/png" href="/images/Sistur-logo.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body class="h-full font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-gradient-to-br from-orange-50 via-white to-orange-50">
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-3">
                    <img src="/images/Sistur-logo.png" alt="Sistur" class="h-16">
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 px-8 py-8">
                {{ $slot }}
            </div>

            <p class="mt-6 text-sm text-gray-400">&copy; {{ date('Y') }} Sistur Angola</p>
        </div>
    </body>
</html>
