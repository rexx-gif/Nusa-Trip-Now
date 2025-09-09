<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - NusaTripNow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>

    <!-- Styles -->
    <style>
        /* =================================
           VARIABLES & RESET
           ================================= */
        :root {
            /* Color Palette - Black, Yellow, White Theme */
            --primary-black: #111827;
            --secondary-black: #1f2937;
            --accent-yellow: #f59e0b;
            --light-yellow: #fef3c7;
            --bright-yellow: #fbbf24;
            --pure-white: #ffffff;
            --light-gray: #f3f4f6;
            --medium-gray: #9ca3af;
            --dark-gray: #4b5563;
            
            /* Functional Colors */
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            
            /* Spacing & Sizing */
            --sidebar-width: 280px;
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
            background-color: rgb(65, 65, 65);
            color: var(--primary-black);
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

        /* Sidebar */
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
            transition: var(--transition);
            box-shadow: var(--shadow-lg);
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--pure-white);
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            color: var(--accent-yellow);
            width: 32px;
            height: 32px;
        }

        .sidebar-nav {
            padding: 24px 16px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            margin: 6px 0;
            border-radius: var(--border-radius-sm);
            color: var(--medium-gray);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--pure-white);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(245, 158, 11, 0.15) 0%, transparent 100%);
            color: var(--accent-yellow);
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
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
            background: rgb(87, 87, 87);
            box-shadow: var(--shadow-sm);
            padding: 0 32px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-black);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-badge {
            position: relative;
            background: none;
            border: none;
            color: var(--dark-gray);
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
        }

        .notification-badge:hover {
            background: var(--light-gray);
        }

        .notification-badge svg {
            width: 24px;
            height: 24px;
        }

        .badge-count {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Area */
        .admin-content {
            flex: 1;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* =================================
           CARDS & GRID
           ================================= */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background: rgb(34, 34, 34);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 24px;
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        

        h3.card-title{
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            border-left: 4px solid var(--accent-yellow);
        }

        .stat-icon-wrapper {
            padding: 16px;
            border-radius: 16px;
            background: var(--light-yellow);
            color: var(--accent-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-wrapper svg {
            width: 24px;
            height: 24px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-title {
            color: white;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: rgb(177, 177, 177);
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }

        .chart-card {
            display: flex;
            flex-direction: column;
        }

        .card-title {
            position: relative;
            bottom: 5px;
            text-align: center;
            padding: 1rem 1rem; /* Padding atas-bawah 1.2rem, kiri-kanan 1.5rem */
            margin: 0;
            font-size: 1.35rem;
            font-weight: 600;
            color: #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 60px; /* Tinggi minimum untuk konsistensi */
            line-height: 1.4;
            box-sizing: border-box;
        }

        .card-title svg {
            width: 24px;
            height: 24px;
            color: var(--accent-yellow);
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* =================================
           TABLES
           ================================= */
        .table-container {
            background: rgb(63, 63, 63);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header {
            background: var(--secondary-black);
        }

        .table-header th {
            padding: 16px 20px;
            text-align: left;
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        

        .table-row {
            border-bottom: 1px solid var(--light-gray);
            transition: var(--transition);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: #868282;
            color: white;
        }

        .table-row td {
            padding: 16px 20px;
            color: var(--dark-gray);
        }

        .text-center {
            text-align: center;
        }

        tr.table-row td{
            color: white;
        }

        /* =================================
           BUTTONS & BADGES
           ================================= */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn:focus {
            outline: 2px solid var(--accent-yellow);
            outline-offset: 2px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .btn-primary {
            background: var(--accent-yellow);
            color: var(--primary-black);
        }

        .btn-primary:hover {
            background: var(--bright-yellow);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-waiting {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* =================================
           LIVE CHAT COMPONENT
           ================================= */
        .chat-section {
            background: rgb(34, 34, 34);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .chat-container {
            display: flex;
            height: 500px;
        }

        /* Chat Sidebar */
        .chat-sidebar {
            width: 35%;
            border-right: 1px solid var(--light-gray);
            display: flex;
            flex-direction: column;
        }

        .chat-sidebar-header {
            padding: 20px;
            background: var(--secondary-black);
            color: var(--pure-white);
        }

        .chat-sidebar-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .user-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid var(--light-gray);
            cursor: pointer;
            transition: var(--transition);
        }

        .user-item:hover {
            background: var(--light-yellow);
        }

        .user-item.active {
            background: var(--light-yellow);
            border-left: 4px solid var(--accent-yellow);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-black);
            font-weight: 600;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: var(--primary-black);
            margin-bottom: 4px;
        }

        .user-status {
            font-size: 0.75rem;
            color: var(--medium-gray);
        }

        /* Chat Main */
        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
            background: var(--pure-white);
        }

        .chat-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-black);
            text-align: center;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #181818;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            line-height: 1.4;
        }

        .message.received {
            align-self: flex-start;
            background: var(--pure-white);
            border: 1px solid var(--light-gray);
            border-bottom-left-radius: 4px;
        }

        .message.sent {
            align-self: flex-end;
            background: var(--accent-yellow);
            color: var(--primary-black);
            border-bottom-right-radius: 4px;
        }

        .chat-input-container {
            padding: 20px;
            border-top: 1px solid var(--light-gray);
            background: rgb(94, 94, 94);
        }

        .chat-form {
            display: flex;
            gap: 12px;
        }

        .chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-sm);
            font-family: inherit;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .chat-input:focus {
            outline: none;
            border-color: var(--accent-yellow);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .chat-submit {
            padding: 12px 20px;
            background: var(--accent-yellow);
            color: var(--primary-black);
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .chat-submit:hover {
            background: var(--bright-yellow);
        }

        /* =================================
           UTILITIES & RESPONSIVE
           ================================= */
        .alert {
            padding: 16px 20px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 24px;
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid var(--success);
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: var(--medium-gray);
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 16px;
            color: var(--light-gray);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-sidebar.active {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .admin-content {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .chat-container {
                flex-direction: column;
                height: 600px;
            }
            
            .chat-sidebar {
                width: 100%;
                height: 40%;
                border-right: none;
                border-bottom: 1px solid var(--light-gray);
            }
            
            .chat-main {
                height: 60%;
            }
        }

        /* Animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
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
                <h1 class="header-title">Dashboard Admin</h1>
                
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
                <div class="alert">
                    <p class="alert-title">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="card stat-card">
                        <div class="stat-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="stat-content">
                            <p class="stat-title">Total Penjualan</p>
                            <p class="stat-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <div class="card stat-card">
                        <div class="stat-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="stat-content">
                            <p class="stat-title">Total Booking</p>
                            <p class="stat-value">{{ $allBookings->total() }}</p>
                        </div>
                    </div>
                    
                    <div class="card stat-card">
                        <div class="stat-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="stat-content">
                            <p class="stat-title">Menunggu Konfirmasi</p>
                            <p class="stat-value">{{ $pendingConfirmations->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="card stat-card">
                        <div class="stat-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="stat-content">
                            <p class="stat-title">Pengguna Aktif</p>
                            <p class="stat-value">{{ $chatUsers->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Charts Grid -->
                <div class="charts-grid">
                    <div class="card chart-card">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Trend Booking Bulanan
                        </h3>
                        <div class="chart-container">
                            <canvas id="bookingChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="card chart-card">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 极速快三 5.597 20.963 8.5 21c1.25 0 2.5-.125 3.75-.375A9 9 0 0011 3.055z" />
                            </svg>
                            Status Booking
                        </h3>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pending Confirmations Table -->
                <div class="card">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 极速快三 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 极速快三 9 9 0 0118 0z" />
                        </svg>
                        Menunggu Konfirmasi Pembayaran
                    </h3>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    <th>User</th>
                                    <th>Paket Wisata</th>
                                    <th>Hotel</th>
                                    <th class="text-center">Tanggal Booking</th>
                                    <th class="text-center">Bukti Transfer</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingConfirmations as $booking)
                                <tr class="table-row">
                                    <td>{{ $booking->user ? $booking->user->name : 'User tidak ditemukan' }}</td>
                                    <td>{{ $booking->tour ? $booking->tour->name : 'Tour tidak ditemukan' }}</td>
                                    <td>{{ $booking->with_hotel && $booking->hotel ? $booking->hotel->name : ($booking->with_hotel ? 'N/A' : 'Tidak') }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        @if($booking->proof_of_payment && file_exists(storage_path('app/public/' . $booking->proof_of_payment)))
                                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="btn btn-primary btn-sm">
                                            Lihat Bukti
                                        </a>
                                        @else
                                        <span class="text-danger">Bukti tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr class="table-row">
                                    <td colspan="6" class="text-center">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p>Tidak ada pembayaran yang menunggu konfirmasi</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bookings History Table -->
                <div class="card">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2极速快三v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        History Semua Penyewaan
                    </h3>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead class="table-header">
                                <tr>
                                    <th>User</th>
                                    <th>Paket Wisata</th>
                                    <th>Hotel</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allBookings as $booking)
                                <tr class="table-row">
                                    <td>{{ $booking->user ? $booking->user->name : 'User tidak ditemukan' }}</td>
                                    <td>{{ $booking->tour ? $booking->tour->name : 'Tour tidak ditemukan' }}</td>
                                    <td>{{ $booking->with_hotel && $booking->hotel ? $booking->hotel->name : ($booking->with_hotel ? 'N/A' : 'Tidak memilih hotel') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                    <td>{{ $booking->quantity }} orang</td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($booking->status == 'paid' || $booking->status == 'completed')
                                            <span class="status-badge status-paid">Paid</span>
                                        @elseif($booking->status == 'pending_confirmation')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif($booking->status == 'waiting_payment')
                                            <span class="status-badge status-waiting">Waiting</span>
                                        @else
                                            <span class="status-badge status-cancelled">Cancelled</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr class="table-row">
                                    <td colspan="7" class="text-center">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p>Belum ada data penyewaan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Live Chat Section -->
                <div class="chat-section">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Live Chat Support
                    </h3>
                    
                    <div class="chat-container">
                        <!-- Chat Sidebar -->
                        <div class="chat-sidebar">
                            <div class="chat-sidebar-header">
                                <h3>Percakapan Aktif</h3>
                            </div>
                            
                            <ul class="user-list">
                                @forelse($chatUsers as $user)
                                <li class="user-item user-chat-item" data-userid="{{ $user->id }}" data-username="{{ $user->name }}">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <p class="user-name">{{ $user->name }}</p>
                                        <p class="user-status">Terakhir aktif: {{ \Carbon\Carbon::now()->subMinutes(rand(5, 120))->diffForHumans() }}</p>
                                    </div>
                                </li>
                                @empty
                                <li class="user-item">
                                    <div class="empty-state">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 极速快三 0-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                        <p>Belum ada percakapan</p>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        
                        <!-- Chat Main -->
                        <div class="chat-main">
                            <div class="chat-header">
                                <h3 id="chat-with-user-name">Pilih percakapan untuk memulai</h3>
                            </div>
                            
                            <div id="admin-chat-messages" class="chat-messages">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2极速快三v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <p>Pilih user dari panel kiri untuk melihat percakapan</p>
                                </div>
                            </div>
                            
                            <div class="chat-input-container">
                                <form id="admin-chat-form" class="chat-form">
                                    <input type="hidden" id="admin-chat-user-id">
                                    <input type="text" id="admin-chat-input" class="chat-input" placeholder="Ketik balasan Anda..." autocomplete="off" disabled>
                                    <button type="submit" class="chat-submit" disabled>Kirim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Echo/Pusher
            try {
                window.Pusher = Pusher;
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ env("PUSHER_APP_KEY") }}',
                    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                    forceTLS: true
                });
            } catch (e) {
                console.error("Gagal inisialisasi Laravel Echo", e);
            }

            // Initialize Charts
            const bookingCtx = document.getElementById('bookingChart')?.getContext('2d');
            if (bookingCtx) {
                new Chart(bookingCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Jumlah Booking',
                            data: [12, 19, 8, 15, 17, 22, 18, 25, 22, 30, 26, 35],
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderColor: 'rgba(245, 158, 11, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointRadius: 4,
                            pointBackgroundColor: 'rgba(245, 158, 11, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { drawBorder: false } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const statusCtx = document.getElementById('statusChart')?.getContext('2d');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Paid', 'Pending Confirmation', 'Waiting Payment', 'Cancelled'],
                        datasets: [{
                            data: [45, 15, 25, 5],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderColor: [
                                'rgba(16, 185, 129, 1)',
                                'rgba(245, 158, 11, 1)',
                                'rgba(59, 130, 246, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            }

            // Live Chat Functionality
            const userListItems = document.querySelectorAll('.user-chat-item');
            const chatMessagesContainer = document.getElementById('admin-chat-messages');
            const chatForm = document.getElementById('admin-chat-form');
            const chatHeader = document.getElementById('chat-with-user-name');
            const userIdInput = document.getElementById('admin-chat-user-id');
            const chatInput = document.getElementById('admin-chat-input');
            const chatSubmit = chatForm.querySelector('button[type="submit"]');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let currentListeningUserId = null;

            userListItems.forEach(item => {
                item.addEventListener('click', function() {
                    const userId = this.dataset.userid;
                    const userName = this.dataset.username;

                    // Update active state
                    userListItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    if (currentListeningUserId !== userId) {
                        loadChatForUser(userId, userName);
                    }
                });
            });

            async function loadChatForUser(userId, userName) {
                if (currentListeningUserId) {
                    window.Echo.leave(`livechat.${currentListeningUserId}`);
                }
                
                currentListeningUserId = userId;
                chatHeader.textContent = `Sedang chat dengan ${userName}`;
                chatMessagesContainer.innerHTML = '<div class="empty-state"><p>Memuat riwayat chat...</p></div>';
                userIdInput.value = userId;
                
                // Enable chat input
                chatInput.disabled = false;
                chatSubmit.disabled = false;

                try {
                    const response = await fetch(`/chat/history/${userId}?mode=all`);
                    const history = await response.json();

                    chatMessagesContainer.innerHTML = '';
                    
                    if (history.length === 0) {
                        chatMessagesContainer.innerHTML = '<div class="empty-state"><p>Belum ada pesan. Mulai percakapan sekarang!</p></div>';
                    } else {
                        history.forEach(chat => {
                            appendMessage(chat.message, chat.sender);
                        });
                    }

                    // Listen for new messages
                    window.Echo.private(`livechat.${userId}`)
                        .listen('NewChatMessage', (e) => {
                            if (e.userId == currentListeningUserId) {
                                appendMessage(e.message, e.sender);
                            }
                        });

                } catch (error) {
                    console.error('Gagal memuat chat history:', error);
                    chatMessagesContainer.innerHTML = '<div class="empty-state"><p>Gagal memuat riwayat chat</p></div>';
                }
            }

            function appendMessage(message, sender) {
                const messageEl = document.createElement('div');
                messageEl.className = `message ${sender === 'agent' ? 'sent' : 'received'}`;
                messageEl.textContent = message;
                chatMessagesContainer.appendChild(messageEl);
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                const userId = userIdInput.value;

                if (message && userId) {
                    appendMessage(message, 'agent');
                    chatInput.value = '';

                    fetch('/admin/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            message: message,
                            user_id: userId
                        })
                    }).catch(err => console.error('Gagal mengirim pesan:', err));
                }
            });
        });
    </script>
</body>
</html>