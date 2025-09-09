@extends('layouts.admin-dashboard')

@section('page-title', 'Manajemen User')

@section('page-content')
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Manajemen User</h1>
            <p class="text-gray-300 text-lg">Kelola semua pengguna yang terdaftar di platform NusaTripNow</p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-6 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="card stat-card bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center p-6">
                <div class="flex-shrink-0">
                    <div class="stat-icon-wrapper bg-blue-500/20 p-3 rounded-lg">
                        <i class="fas fa-users text-blue-100 text-2xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-blue-100 text-sm font-medium">Total User</p>
                    <p class="text-white text-2xl font-bold">{{ $users->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="card stat-card bg-gradient-to-r from-green-600 to-green-700">
            <div class="flex items-center p-6">
                <div class="flex-shrink-0">
                    <div class="stat-icon-wrapper bg-green-500/20 p-3 rounded-lg">
                        <i class="fas fa-user-check text-green-100 text-2xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-green-100 text-sm font-medium">User Aktif</p>
                    <p class="text-white text-2xl font-bold">{{ $users->where('email_verified_at', '!=', null)->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="card stat-card bg-gradient-to-r from-purple-600 to-purple-700">
            <div class="flex items-center p-6">
                <div class="flex-shrink-0">
                    <div class="stat-icon-wrapper bg-purple-500/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-check text-purple-100 text-2xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-purple-100 text-sm font-medium">Total Booking</p>
                    <p class="text-white text-2xl font-bold">{{ $users->sum(function($user) { return $user->bookings->count(); }) }}</p>
                </div>
            </div>
        </div>

        <!-- New Users This Month -->
        <div class="card stat-card bg-gradient-to-r from-yellow-600 to-yellow-700">
            <div class="flex items-center p-6">
                <div class="flex-shrink-0">
                    <div class="stat-icon-wrapper bg-yellow-500/20 p-3 rounded-lg">
                        <i class="fas fa-user-plus text-yellow-100 text-2xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-yellow-100 text-sm font-medium">User Baru Bulan Ini</p>
                    <p class="text-white text-2xl font-bold">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
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
                            placeholder="Cari nama atau email user..."
                            class="w-full pl-10 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary px-8 py-3">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-secondary px-6 py-3">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border border-gray-600 rounded-xl shadow-lg overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 border-b border-gray-600 bg-gray-800/50">
            <div class="flex items-center gap-3 mb-4 sm:mb-0">
                <div class="p-2 bg-yellow-500/20 rounded-lg">
                    <i class="fas fa-users text-yellow-500 text-xl"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-white">Daftar User</h3>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span class="px-3 py-1 bg-gray-700 rounded-full text-xs sm:text-sm">
                    {{ $users->count() }} / {{ $users->total() }} user
                </span>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-16">
                            ID
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-20">
                            Foto
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider min-w-0">
                            Nama
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider min-w-0">
                            Email
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-32">
                            Telepon
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-24">
                            Booking
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-32">
                            Registrasi
                        </th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-medium text-gray-300 uppercase tracking-wider w-40">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse ($users as $user)
                    <tr class="table-row">
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <span class="text-white font-medium">{{ $user->id }}</span>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="relative group">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                         class="h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-full border border-gray-600 shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                @else
                                    <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold text-sm sm:text-base">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="max-w-xs">
                                <div class="font-semibold text-white text-sm sm:text-lg mb-1">{{ $user->name }}</div>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-900/50 text-red-300 border border-red-700/50">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Belum Verifikasi
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="text-white">{{ $user->email }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <span class="text-white">{{ $user->phone ?: '-' }}</span>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <span class="text-white font-medium">{{ $user->bookings->count() }}</span>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="text-white text-sm">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</div>
                            <div class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-3 sm:py-4">
                            <div class="flex justify-center gap-1 sm:gap-2">
                                <!-- View Button -->
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gray-600 hover:bg-gray-500 text-white transition-colors duration-200 group"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye text-xs sm:text-sm group-hover:scale-110 transition-transform"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-yellow-600 hover:bg-yellow-500 text-white transition-colors duration-200 group"
                                   title="Edit">
                                    <i class="fas fa-edit text-xs sm:text-sm group-hover:scale-110 transition-transform"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait akan hilang.');">
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
                        <td colspan="8" class="px-3 sm:px-6 py-12 sm:py-16 text-center">
                            <div class="empty-state max-w-sm sm:max-w-md mx-auto">
                                <div class="flex justify-center mb-4">
                                    <div class="p-3 sm:p-4 bg-gray-700 rounded-full">
                                        <i class="fas fa-users text-gray-500 text-3xl sm:text-4xl"></i>
                                </div>
                                <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Belum ada data user</h3>
                                <p class="text-sm sm:text-base text-gray-400 mb-4 sm:mb-6">Belum ada pengguna yang terdaftar di platform</p>
                                <a href="{{ route('admin.users.create') }}"
                                   class="btn btn-primary inline-flex items-center px-4 sm:px-6 py-2 sm:py-3">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Tambah User Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-600 bg-gray-800/30">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="text-sm text-gray-400">
                    Menampilkan <span class="font-medium text-white">{{ $users->firstItem() }}-{{ $users->lastItem() }}</span>
                    dari <span class="font-medium text-white">{{ $users->total() }}</span> hasil
                </div>
                <div class="flex justify-center">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
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
@endsection
