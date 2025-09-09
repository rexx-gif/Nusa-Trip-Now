<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Manajemen Wisata - NusaTripNow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* =================================
           VARIABLES & RESET
           ================================= */
        :root {
            --primary-black: #111827;
            --secondary-black: #1f2937;
            --accent-yellow: #f59e0b;
            --light-yellow: #fef3c7;
            --bright-yellow: #fbbf24;
            --pure-white: #ffffff;
            --medium-gray: #9ca3af;
            --dark-gray: #4b5563;
            --success: #10b981;
            --danger: #ef4444;
            
            --sidebar-width: 260px;
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-black);
            color: var(--pure-white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* =================================
           LAYOUT COMPONENTS
           ================================= */
        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Minimalis */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: var(--primary-black);
            color: var(--pure-white);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            height: 100vh;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--pure-white);
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            color: var(--accent-yellow);
            width: 28px;
            height: 28px;
        }

        .sidebar-nav {
            padding: 20px 12px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin: 4px 0;
            border-radius: var(--border-radius-sm);
            color: var(--medium-gray);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--pure-white);
        }

        .nav-item.active {
            background: rgba(245, 158, 11, 0.1);
            color: var(--accent-yellow);
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 50%;
            width: 3px;
            background-color: var(--accent-yellow);
            border-radius: 0 2px 2px 0;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .admin-header {
            background: var(--secondary-black);
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--pure-white);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notification-badge {
            position: relative;
            background: none;
            border: none;
            color: var(--medium-gray);
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: var(--transition);
        }

        .notification-badge:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-badge svg {
            width: 20px;
            height: 20px;
        }

        .badge-count {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 0.65rem;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* =================================
           CONTENT STYLES (Manajemen Wisata)
           ================================= */
        .flex {
            display: flex;
        }
        
        .flex-col {
            flex-direction: column;
        }
        
        .flex-row {
            flex-direction: row;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .gap-4 {
            gap: 1rem;
        }
        
        .gap-6 {
            gap: 1.5rem;
        }
        
        .mb-8 {
            margin-bottom: 2rem;
        }

        /* Grid Utilities */
        .grid {
            display: grid;
        }
        
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        
        /* Card Styles */
        .card {
            background: var(--secondary-black);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 20px;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon-wrapper {
            padding: 14px;
            border-radius: 12px;
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-wrapper i {
            font-size: 1.25rem;
        }

        .stat-content {
            flex: 1;
        }

        .stat-title {
            color: var(--medium-gray);
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--pure-white);
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--accent-yellow);
            color: var(--primary-black);
        }

        .btn-primary:hover {
            background: var(--bright-yellow);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--pure-white);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-container {
            background: var(--secondary-black);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .table-header {
            background: rgba(0, 0, 0, 0.2);
        }

        .table-header th {
            padding: 14px 16px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--medium-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .table-row td {
            padding: 14px 16px;
            color: var(--pure-white);
            font-size: 0.9rem;
        }

        /* Text Utilities */
        .text-white {
            color: var(--pure-white);
        }
        
        .text-gray-300 {
            color: var(--medium-gray);
        }
        
        .text-3xl {
            font-size: 1.875rem;
        }
        
        .text-lg {
            font-size: 1.125rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 240px;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 101;
                background: var(--accent-yellow);
                color: var(--primary-black);
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }
        }

        @media (max-width: 768px) {
            .admin-content {
                padding: 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .grid-cols-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .grid-cols-4 {
                grid-template-columns: 1fr;
            }
            
            .admin-header {
                padding: 0 16px;
                height: 60px;
            }
            
            .header-title {
                font-size: 1.1rem;
            }
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar Minimalis -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    <svg xmlns="http://www.w3.org/2000/svg" class="sidebar-brand-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>NusaTripNow</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.tours.index') }}" class="nav-item {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Manajemen Wisata</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <span>Manajemen User</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Laporan</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <h1 class="header-title">Manajemen Wisata</h1>

                <div class="header-actions">
                    <button class="notification-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="badge-count">3</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <!-- Alert Notification -->
                @if(session('success'))
                <div class="alert" style="background: rgba(16, 185, 129, 0.2); color: #10b981; padding: 12px 16px; border-radius: 8px; border-left: 4px solid var(--success); margin-bottom: 20px;">
                    <p style="font-weight: 600; margin-bottom: 4px;">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <!-- Header Section -->
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Manajemen Paket Wisata</h1>
                        <p class="text-gray-300 text-lg">Kelola semua paket wisata yang tersedia di platform NusaTripNow</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Tambah Wisata Baru
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Wisata -->
                    <div class="card stat-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="stat-icon-wrapper">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="stat-title">Total Wisata</p>
                                <p class="stat-value">{{ $tours->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div class="card stat-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="stat-icon-wrapper">
                                    <i class="fas fa-globe-asia"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="stat-title">Provinsi</p>
                                <p class="stat-value">{{ $tours->pluck('province.name')->unique()->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="card stat-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="stat-icon-wrapper">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="stat-title">Kategori</p>
                                <p class="stat-value">{{ $tours->pluck('categories')->flatten()->pluck('name')->unique()->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rata-rata Harga -->
                    <div class="card stat-card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="stat-icon-wrapper">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="stat-title">Rata-rata Harga</p>
                                <p class="stat-value">Rp {{ number_format($tours->avg('price'), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="card mb-8">
                    <div class="p-6">
                        <form method="GET" class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Cari nama wisata atau deskripsi..."
                                        class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="btn btn-primary">
                                    Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.tours.index') }}" 
                                       class="btn btn-secondary">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tours Table -->
                <div class="card overflow-hidden">
                    <!-- Table Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-6 border-b border-gray-600 bg-gray-800/50">
                        <div class="flex items-center gap-3 mb-4 sm:mb-0">
                            <div class="p-2 bg-yellow-500/20 rounded-lg">
                                <i class="fas fa-map-marked-alt text-yellow-500 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white">Daftar Paket Wisata</h3>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <span class="px-3 py-1 bg-gray-700 rounded-full text-sm">
                                {{ $tours->count() }} / {{ $tours->total() }} paket wisata
                            </span>
                        </div>
                    </div>

                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Gambar
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Nama Wisata
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Provinsi
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-medium uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-600">
                                @forelse ($tours as $tour)
                                <tr class="table-row">
                                    <td class="px-6 py-4">
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}"
                                                 class="h-16 w-24 object-cover rounded-lg border border-gray-600 shadow-sm">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <div class="font-semibold text-white text-lg mb-1">{{ $tour->name }}</div>
                                            <div class="text-sm text-gray-400">{{ Str::limit($tour->description, 100) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-900/50 text-blue-300 border border-blue-700/50">
                                            <i class="fas fa-map-marker-alt mr-1 text-xs"></i>
                                            {{ $tour->province->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1 max-w-xs">
                                            @forelse($tour->categories as $category)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                                    {{ Str::limit($category->name, 8) }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-500 italic">Tidak ada kategori</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-lg">Rp {{ number_format($tour->price, 0, ',', '.') }}</div>
                                        <div class="text-sm text-gray-400">per orang</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.tours.show', $tour) }}"
                                               class="btn btn-sm btn-secondary"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.tours.edit', $tour) }}"
                                               class="btn btn-sm btn-primary"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="inline-block"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket wisata ini? Semua data terkait akan hilang.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="table-row">
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="empty-state">
                                            <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 16px; color: var(--medium-gray);"></i>
                                            <h3 class="text-xl font-semibold text-white mb-2">Belum ada data paket wisata</h3>
                                            <p class="text-gray-400 mb-6">Silakan tambahkan paket wisata pertama untuk memulai mengelola destinasi wisata</p>
                                            <a href="{{ route('admin.tours.create') }}"
                                               class="btn btn-primary">
                                                <i class="fas fa-plus-circle mr-2"></i>
                                                Tambah Wisata Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($tours->hasPages())
                    <div class="px-6 py-4 border-t border-gray-600 bg-gray-800/30">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="text-sm text-gray-400">
                                Menampilkan <span class="font-medium text-white">{{ $tours->firstItem() }}-{{ $tours->lastItem() }}</span> 
                                dari <span class="font-medium text-white">{{ $tours->total() }}</span> hasil
                            </div>
                            <div class="flex justify-center">
                                {{ $tours->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tambahkan efek interaktif pada card statistik
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.2)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
            });
        });

        // Responsive sidebar toggle untuk mobile
        const sidebar = document.querySelector('.admin-sidebar');
        if (window.innerWidth <= 1024) {
            const toggleButton = document.createElement('button');
            toggleButton.className = 'sidebar-toggle';
            toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
            document.body.appendChild(toggleButton);
        }
    </script>
</body>
</html>