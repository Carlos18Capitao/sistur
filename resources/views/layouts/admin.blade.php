<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ isset($title) ? $title . ' — ' : '' }}Sistur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0 flex flex-col hidden md:flex">
        <div class="p-5 border-b border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-globe-africa text-white"></i>
                </div>
                <span class="font-bold text-lg">Sis<span class="text-orange-400">tur</span> <span class="text-gray-400 text-sm font-normal">Admin</span></span>
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                    ['route' => 'admin.tours.index', 'icon' => 'fa-map-marked-alt', 'label' => 'Tours'],
                    ['route' => 'admin.bookings.index', 'icon' => 'fa-calendar-check', 'label' => 'Reservas'],
                    ['route' => 'admin.reviews.index', 'icon' => 'fa-star', 'label' => 'Avaliações'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs($item['route']) || request()->routeIs($item['route'].'*') ? 'bg-orange-500 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas {{ $item['icon'] }} w-4"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-400 hover:text-white text-sm transition mb-2">
                <i class="fas fa-external-link-alt w-4"></i>Ver site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-red-400 hover:text-red-300 text-sm transition w-full">
                    <i class="fas fa-sign-out-alt w-4"></i>Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <i class="fas fa-user-circle text-gray-400"></i>
                {{ auth()->user()->name }}
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>{{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>
