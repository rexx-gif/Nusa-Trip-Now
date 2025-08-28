<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - NusaTripNow</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-bold">
                    NusaTripNow
                </a>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block py-2.5 px-6 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : '' }}">
                   Dashboard
                </a>
                <a href="{{ route('admin.tours.index') }}" 
                   class="block py-2.5 px-6 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.tours.*') ? 'bg-gray-900' : '' }}">
                   Manajemen Wisata
                </a>
                <!-- Link navigasi admin lainnya bisa ditambahkan di sini -->
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title')
                    </h2>
                    
                    <!-- User Dropdown -->
                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 sm:p-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
