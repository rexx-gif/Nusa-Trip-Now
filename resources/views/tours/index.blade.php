<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Paket Wisata - {{ config('app.name', 'Laravel') }}</title>

    {{-- Menghubungkan ke font dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Custom CSS --}}
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .dark {
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --border-color: #374151;
            --card-bg: #1f2937;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            box-shadow: var(--shadow);
        }

        .filter-section {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .province-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .province-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .province-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .dark .province-card {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }

        .filter-toggle {
            display: none;
        }

        @media (max-width: 768px) {
            .filter-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                z-index: 50;
                transition: left 0.3s ease;
            }

            .filter-sidebar.open {
                left: 0;
            }

            .filter-toggle {
                display: block;
            }

            .filter-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 40;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .filter-overlay.active {
                opacity: 1;
                visibility: visible;
            }
        }
    </style>
</head>
<body class="font-['Inter']">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-900 shadow-lg border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mr-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">NusaTripNow</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    @auth
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Dashboard Admin</a>
                                <hr class="border-gray-200 dark:border-gray-600">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Pilihan Paket Wisata</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">Jelajahi destinasi impian Anda dengan penawaran terbaik dari kami</p>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('tours.index') }}" class="max-w-2xl mx-auto">
                <div class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari destinasi atau nama wisata..."
                           class="flex-1 px-4 py-3 rounded-l-lg border-0 focus:ring-2 focus:ring-white focus:ring-opacity-50 text-gray-900">
                    <button type="submit" class="bg-white text-blue-600 px-6 py-3 rounded-r-lg hover:bg-gray-100 transition-colors font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filter Sidebar -->
            <div class="filter-sidebar lg:w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Pencarian</h3>
                    <button class="filter-toggle lg:hidden p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form method="GET" action="{{ route('tours.index') }}" class="space-y-6">
                    <!-- Province Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Provinsi</label>
                        <select name="province" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" {{ request('province') == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Inclusion Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Inklusi</label>
                        <select name="inclusion" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Inklusi</option>
                            @foreach($inclusions as $inclusion)
                                <option value="{{ $inclusion->id }}" {{ request('inclusion') == $inclusion->id ? 'selected' : '' }}>
                                    {{ $inclusion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('tours.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Mobile Filter Toggle -->
                <button class="filter-toggle lg:hidden mb-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>

                <!-- Province Showcase -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Jelajahi Berdasarkan Provinsi</h2>
                    <div class="province-grid">
                        @foreach($provinces->take(8) as $province)
                            <div class="province-card" onclick="filterByProvince({{ $province->id }})">
                                <h3 class="text-lg font-semibold">{{ $province->name }}</h3>
                                <p class="text-sm opacity-90">Temukan wisata terbaik</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Results Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Paket Wisata {{ $tours->total() > 0 ? '(' . $tours->total() . ' hasil)' : '' }}
                    </h2>
                </div>

                <!-- Tour Grid -->
                @if($tours->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($tours as $tour)
                            <div class="card rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}"
                                         class="w-full h-48 object-cover">
                                    <div class="absolute top-4 right-4 bg-white dark:bg-gray-800 px-3 py-1 rounded-full text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $tour->province->name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        <a href="{{ route('tours.show', $tour) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                            {{ $tour->name }}
                                        </a>
                                    </h3>

                                    <div class="flex items-center text-gray-600 dark:text-gray-400 mb-3">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $tour->location }}
                                    </div>

                                    @if($tour->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @foreach($tour->categories->take(3) as $category)
                                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                            @if($tour->categories->count() > 3)
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-full">
                                                    +{{ $tour->categories->count() - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($tour->inclusions->count() > 0)
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            @foreach($tour->inclusions->take(3) as $inclusion)
                                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $inclusion->name }}
                                                </span>
                                            @endforeach
                                            @if($tour->inclusions->count() > 3)
                                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-full">
                                                    +{{ $tour->inclusions->count() - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Mulai dari</p>
                                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                Rp {{ number_format($tour->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <a href="{{ route('tours.show', $tour) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors font-medium">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Hotel Selection Section -->
                    @if($tours->count() > 0 && $hotels->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pilih Hotel untuk Paket Wisata Anda</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Pilih hotel yang sesuai dengan preferensi Anda. Harga bervariasi berdasarkan lokasi dan fasilitas.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($hotels as $hotel)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $hotel->name }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $hotel->province->name ?? 'N/A' }}</span>
                                        </div>

                                        @if($hotel->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($hotel->description, 80) }}</p>
                                        @endif

                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">Harga per malam</p>
                                                <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                                    Rp {{ number_format($hotel->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                                Pilih Hotel
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Catatan:</p>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">Harga hotel dapat bervariasi tergantung pada tanggal menginap dan ketersediaan. Hubungi kami untuk konfirmasi harga terbaru.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $tours->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-.98-5.5-2.5M12 4v.01" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Tidak ada paket wisata ditemukan</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Coba ubah filter pencarian atau cari dengan kata kunci yang berbeda.</p>
                        <a href="{{ route('tours.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Overlay for Mobile -->
    <div class="filter-overlay"></div>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.classList.toggle('dark', currentTheme === 'dark');

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            const theme = html.classList.contains('dark') ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
        });

        // Mobile Filter Toggle
        const filterToggle = document.querySelector('.filter-toggle');
        const filterSidebar = document.querySelector('.filter-sidebar');
        const filterOverlay = document.querySelector('.filter-overlay');

        filterToggle.addEventListener('click', () => {
            filterSidebar.classList.toggle('open');
            filterOverlay.classList.toggle('active');
        });

        filterOverlay.addEventListener('click', () => {
            filterSidebar.classList.remove('open');
            filterOverlay.classList.remove('active');
        });

        // Province Filter Function
        function filterByProvince(provinceId) {
            const url = new URL(window.location);
            url.searchParams.set('province', provinceId);
            window.location.href = url.toString();
        }

        // Auto-hide mobile filter on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                filterSidebar.classList.remove('open');
                filterOverlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>