<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Wisata - NusaTripNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f'
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            color: #f1f5f9;
        }
        
        .card {
            background-color: #1e293b;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon-wrapper {
            border-radius: 0.5rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: #f59e0b;
            color: #0f172a;
        }
        
        .btn-primary:hover {
            background-color: #fbbf24;
            transform: scale(1.05);
        }
        
        .btn-secondary {
            background-color: #334155;
            color: #e2e8f0;
        }
        
        .btn-secondary:hover {
            background-color: #475569;
            transform: scale(1.05);
        }
        
        .btn-danger {
            background-color: #dc2626;
            color: #fef2f2;
        }
        
        .btn-danger:hover {
            background-color: #ef4444;
            transform: scale(1.05);
        }
        
        .table-header {
            background-color: #1a2438;
        }
        
        .table-row {
            transition: background-color 0.2s ease;
        }
        
        .table-row:hover {
            background-color: #2d374850;
        }
        
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pagination li {
            margin: 0 0.25rem;
        }
        
        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.25rem;
            height: 2.25rem;
            padding: 0 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid #334155;
            background-color: #1e293b;
            color: #cbd5e1;
            transition: all 0.2s ease;
        }
        
        .pagination a:hover {
            background-color: #334155;
            color: #f1f5f9;
        }
        
        .pagination .active span {
            background-color: #f59e0b;
            color: #0f172a;
            border-color: #f59e0b;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }
        
        @media (max-width: 640px) {
            .stat-card .flex {
                flex-direction: column;
                text-align: center;
            }
            
            .stat-card .ml-4 {
                margin-left: 0;
                margin-top: 0.75rem;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-dark-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 mb-8">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-white mb-2">Manajemen Paket Wisata</h1>
                <p class="text-gray-300 text-lg">Kelola semua paket wisata yang tersedia di platform NusaTripNow</p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('admin.tours.create') }}" class="btn btn-primary px-6 py-3">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Wisata Baru
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Wisata -->
            <div class="card stat-card bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-wrapper bg-blue-500/20 p-3 rounded-lg">
                            <i class="fas fa-map-marked-alt text-blue-100 text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-blue-100 text-sm font-medium">Total Wisata</p>
                        <p class="text-white text-2xl font-bold">{{ $tours->total() }}</p>
                    </div>
                </div>
            </div>

            <!-- Provinsi -->
            <div class="card stat-card bg-gradient-to-r from-green-600 to-green-700">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-wrapper bg-green-500/20 p-3 rounded-lg">
                            <i class="fas fa-globe-asia text-green-100 text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-green-100 text-sm font-medium">Provinsi</p>
                        <p class="text-white text-2xl font-bold">{{ $tours->pluck('province.name')->unique()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Kategori -->
            <div class="card stat-card bg-gradient-to-r from-purple-600 to-purple-700">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-wrapper bg-purple-500/20 p-3 rounded-lg">
                            <i class="fas fa-tags text-purple-100 text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-purple-100 text-sm font-medium">Kategori</p>
                        <p class="text-white text-2xl font-bold">{{ $tours->pluck('categories')->flatten()->pluck('name')->unique()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Harga -->
            <div class="card stat-card bg-gradient-to-r from-yellow-600 to-yellow-700">
                <div class="flex items-center p-6">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-wrapper bg-yellow-500/20 p-3 rounded-lg">
                            <i class="fas fa-money-bill-wave text-yellow-100 text-2xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-yellow-100 text-sm font-medium">Rata-rata Harga</p>
                        <p class="text-white text-2xl font-bold">Rp {{ number_format($tours->avg('price'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card mb-8 border border-gray-600 rounded-xl shadow-lg">
            <div class="p-6">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama wisata atau deskripsi..."
                                class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary px-8 py-3">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.tours.index') }}" 
                               class="btn btn-secondary px-6 py-3">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tours Table -->
        <div class="card border border-gray-600 rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 border-b border-gray-600 bg-gray-800/50">
                <div class="flex items-center gap-3 mb-4 sm:mb-0">
                    <div class="p-2 bg-yellow-500/20 rounded-lg">
                        <i class="fas fa-map-marked-alt text-yellow-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white">Daftar Paket Wisata</h3>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <span class="px-3 py-1 bg-gray-700 rounded-full text-xs sm:text-sm">
                        {{ $tours->count() }} / {{ $tours->total() }} paket wisata
                    </span>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="table-header">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-20 sm:w-28">
                                Gambar
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider min-w-0">
                                Nama Wisata
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-24 sm:w-32">
                                Provinsi
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-32 sm:w-40">
                                Kategori
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-24 sm:w-32">
                                Harga
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-medium text-gray-300 uppercase tracking-wider w-32 sm:w-40">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @forelse ($tours as $tour)
                        <tr class="table-row">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}"
                                         class="h-12 w-16 sm:h-16 sm:w-24 object-cover rounded-lg border border-gray-600 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-lg transition-colors duration-200"></div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="max-w-xs">
                                    <div class="font-semibold text-white text-sm sm:text-lg mb-1 line-clamp-1">{{ $tour->name }}</div>
                                    <div class="text-xs sm:text-sm text-gray-400 line-clamp-2">{{ Str::limit($tour->description, 100) }}</div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-blue-900/50 text-blue-300 border border-blue-700/50">
                                    <i class="fas fa-map-marker-alt mr-1 sm:mr-1.5 text-xs"></i>
                                    <span class="hidden sm:inline">{{ $tour->province->name ?? 'N/A' }}</span>
                                    <span class="sm:hidden">{{ Str::limit($tour->province->name ?? 'N/A', 8) }}</span>
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @forelse($tour->categories as $category)
                                        <span class="inline-flex items-center px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                            {{ Str::limit($category->name, 8) }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-500 italic">Tidak ada kategori</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="font-bold text-white text-sm sm:text-lg">Rp {{ number_format($tour->price, 0, ',', '.') }}</div>
                                <div class="text-xs sm:text-sm text-gray-400">per orang</div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex justify-center gap-1 sm:gap-2">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.tours.show', $tour) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gray-600 hover:bg-gray-500 text-white transition-colors duration-200 group"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye text-xs sm:text-sm group-hover:scale-110 transition-transform"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.tours.edit', $tour) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-yellow-600 hover:bg-yellow-500 text-white transition-colors duration-200 group"
                                       title="Edit">
                                        <i class="fas fa-edit text-xs sm:text-sm group-hover:scale-110 transition-transform"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket wisata ini? Semua data terkait akan hilang.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-red-600 hover:bg-red-500 text-white transition-colors duration-200 group"
                                                title="Hapus">
                                            <i class="fas fa-trash text-xs sm:text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="table-row">
                            <td colspan="6" class="px-3 sm:px-6 py-12 sm:py-16 text-center">
                                <div class="empty-state max-w-sm sm:max-w-md mx-auto">
                                    <div class="flex justify-center mb-4">
                                        <div class="p-3 sm:p-4 bg-gray-700 rounded-full">
                                            <i class="fas fa-map-marked-alt text-gray-500 text-3xl sm:text-4xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Belum ada data paket wisata</h3>
                                    <p class="text-sm sm:text-base text-gray-400 mb-4 sm:mb-6">Silakan tambahkan paket wisata pertama untuk memulai mengelola destinasi wisata</p>
                                    <a href="{{ route('admin.tours.create') }}"
                                       class="btn btn-primary inline-flex items-center px-4 sm:px-6 py-2 sm:py-3">
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
    </script>
</body>
</html>