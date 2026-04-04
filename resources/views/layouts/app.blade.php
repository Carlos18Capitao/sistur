<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Sistur Angola</title>
    <meta name="description" content="Plataforma de turismo em Angola. Descubra tours incríveis em Luanda, Benguela, Huíla e muito mais.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#fff7ed',100:'#ffedd5',500:'#f97316',600:'#ea580c',700:'#c2410c' }
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        [x-cloak]{display:none!important}
        .line-clamp-2{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2}
        .line-clamp-3{overflow:hidden;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:3}
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-900 font-sans antialiased">

<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-globe-africa text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold text-gray-900">Sis<span class="text-orange-500">tur</span></span>
            </a>
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-500 transition font-medium">Início</a>
                <a href="{{ route('tours.index') }}" class="text-gray-600 hover:text-orange-500 transition font-medium">Tours</a>
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-orange-500 transition font-medium">Minhas Reservas</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-orange-500 transition font-medium"><i class="fas fa-shield-alt mr-1"></i>Admin</a>
                    @endif
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" @click.outside="open=false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fas fa-user-circle mr-2 text-gray-400"></i>Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt mr-2"></i>Sair</button></form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-500 transition font-medium">Entrar</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition font-medium">Registar</a>
                @endauth
            </div>
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-600"><i class="fas fa-bars text-xl"></i></button>
        </div>
    </div>
    <div x-show="mobileOpen" x-cloak class="md:hidden bg-white border-t border-gray-100 px-4 py-3 space-y-2">
        <a href="{{ route('home') }}" class="block py-2 text-gray-700 font-medium">Início</a>
        <a href="{{ route('tours.index') }}" class="block py-2 text-gray-700 font-medium">Tours</a>
        @auth
            <a href="{{ route('bookings.index') }}" class="block py-2 text-gray-700 font-medium">Minhas Reservas</a>
            @if(auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700 font-medium">Admin</a>@endif
            <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf<button type="submit" class="w-full bg-red-50 text-red-600 py-2 rounded-lg font-medium">Sair</button></form>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-gray-700 font-medium">Entrar</a>
            <a href="{{ route('register') }}" class="block bg-orange-500 text-white text-center py-2 rounded-lg font-medium">Registar</a>
        @endauth
    </div>
</nav>

@if(session('success'))
    <div x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,5000)"
         class="fixed top-20 right-4 z-50 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 max-w-sm">
        <i class="fas fa-check-circle"></i><span>{{ session('success') }}</span>
        <button @click="show=false" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,7000)"
         class="fixed top-20 right-4 z-50 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 max-w-sm">
        <i class="fas fa-exclamation-circle"></i><span>{{ session('error') }}</span>
        <button @click="show=false" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
    </div>
@endif

<main>{{ $slot }}</main>

<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-orange-500 rounded-lg flex items-center justify-center"><i class="fas fa-globe-africa text-white text-lg"></i></div>
                    <span class="text-xl font-bold text-white">Sis<span class="text-orange-400">tur</span></span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">Descubra a beleza de Angola através de experiências turísticas únicas e inesquecíveis.</p>
                <div class="flex gap-3 mt-4">
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition"><i class="fab fa-facebook-f text-xs"></i></a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition"><i class="fab fa-instagram text-xs"></i></a>
                    <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-orange-500 transition"><i class="fab fa-whatsapp text-xs"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Explorar</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('tours.index') }}" class="hover:text-orange-400 transition">Todos os Tours</a></li>
                    @foreach(['Luanda', 'Benguela', 'Huíla'] as $city)
                        <li><a href="{{ route('tours.index', ['city' => $city]) }}" class="hover:text-orange-400 transition">Tours em {{ $city }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-3">Contacto</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><i class="fas fa-envelope text-orange-400 w-4"></i>geral@sistur.ao</li>
                    <li class="flex items-center gap-2"><i class="fas fa-phone text-orange-400 w-4"></i>+244 923 000 000</li>
                    <li class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-orange-400 w-4"></i>Luanda, Angola</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 flex flex-col md:flex-row items-center justify-between gap-2 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Sistur Angola. Todos os direitos reservados.</p>
            <p>Desenvolvido em Angola 🇦🇴</p>
        </div>
    </div>
</footer>
</body>
</html>
