<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - NusaTripNow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
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

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

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
            transition: var(--transition);
        }

        .admin-sidebar.collapsed {
            transform: translateX(-100%);
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

        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: var(--transition);
        }

        .admin-main.sidebar-collapsed {
            margin-left: 0;
        }

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

        .sidebar-toggle {
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
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .sidebar-toggle:hover {
            background: var(--bright-yellow);
            transform: scale(1.05);
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

        .admin-content {
            flex: 1;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

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

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
        }

        .btn-danger {
            background: var(--danger);
            color: var(--pure-white);
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .alert {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 12px 16px;
            border-radius: 8px;
            border-left: 4px solid var(--success);
            margin-bottom: 20px;
        }

        .alert p {
            font-weight: 600;
            margin-bottom: 4px;
        }

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
                display: block !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 101;
            }
        }

        @media (max-width: 768px) {
            .admin-content {
                padding: 16px;
            }

            .admin-header {
                padding: 0 16px;
                height: 60px;
            }

            .header-title {
                font-size: 1.1rem;
            }
        }

        @media (min-width: 1025px) {
            .sidebar-toggle {
                display: none;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar" id="adminSidebar">
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

        <main class="admin-main" id="adminMain">
            <header class="admin-header">
                <div class="header-actions">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <h1 class="header-title">@yield('page-title', 'Admin Panel')</h1>

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

            <div class="admin-content">
                @if(session('success'))
                <div class="alert">
                    <p>Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                @if(session('alert'))
                <div class="alert" style="background: rgba(245, 158, 11, 0.2); color: #f59e0b; border-left-color: var(--accent-yellow);">
                    <p>Info!</p>
                    <p>{{ session('alert') }}</p>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.getElementById('adminMain');
            const toggleBtn = document.getElementById('sidebarToggle');

            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });

            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
                main.classList.add('sidebar-collapsed');
            }

            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                        sidebar.classList.add('collapsed');
                        main.classList.add('sidebar-collapsed');
                        localStorage.setItem('sidebarCollapsed', 'true');
                    }
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('collapsed');
                    main.classList.remove('sidebar-collapsed');
                }
            });
        });

        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.15)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
