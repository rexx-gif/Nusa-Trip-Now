<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Wisata - NusaTripNow</title>
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
    </style>
</head>
<body class="min-h-screen bg-dark-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Tambah Paket Wisata Baru</h1>
                <p class="text-gray-300 text-lg">Buat paket wisata baru untuk platform NusaTripNow</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary inline-flex items-center justify-center px-6 py-3">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="card mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Langkah Pembuatan Paket Wisata</h3>
                    <span class="text-sm text-gray-400">Lengkapi semua informasi yang diperlukan</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <span class="text-black font-bold text-sm">1</span>
                        </div>
                        <span class="ml-2 text-white font-medium">Informasi Dasar</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-gray-300 font-bold text-sm">2</span>
                        </div>
                        <span class="ml-2 text-gray-400">Kategori & Fasilitas</span>
                    </div>
                    <div class="flex-1 h-px bg-gray-600"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                            <span class="text-gray-300 font-bold text-sm">3</span>
                        </div>
                        <span class="ml-2 text-gray-400">Hotel & Review</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information Section -->
            <div class="card">
                <div class="flex items-center gap-3 p-6 border-b border-gray-600">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-black text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white">Informasi Dasar</h3>
                        <p class="text-gray-400">Detail utama paket wisata yang akan ditampilkan</p>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Name and Location Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label for="name" class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-tag mr-2 text-yellow-500"></i>
                                Nama Paket Wisata <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                placeholder="Contoh: Wisata Gunung Bromo 3 Hari 2 Malam">
                            @error('name')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-yellow-500"></i>
                                Lokasi Utama <span class="text-red-400">*</span>
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                placeholder="Contoh: Kabupaten Probolinggo, Jawa Timur">
                            @error('location')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="province_id" class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-globe-asia mr-2 text-yellow-500"></i>
                                Provinsi <span class="text-red-400">*</span>
                            </label>
                            <select name="province_id" id="province_id" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                                <option value="" class="bg-gray-700">Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }} class="bg-gray-700">
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Price and Image Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-money-bill-wave mr-2 text-yellow-500"></i>
                                Harga Paket (IDR) <span class="text-red-400">*</span>
                            </label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                placeholder="Contoh: 1250000">
                            @error('price')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-white mb-2">
                                <i class="fas fa-image mr-2 text-yellow-500"></i>
                                Gambar Utama <span class="text-red-400">*</span>
                            </label>
                            <input type="file" name="image" id="image" accept="image/*" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-yellow-500 file:text-black hover:file:bg-yellow-600">
                            @error('image')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-align-left mr-2 text-yellow-500"></i>
                            Deskripsi Paket Wisata <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                            placeholder="Jelaskan detail paket wisata, aktivitas yang dilakukan, dan keunikan destinasi">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary inline-flex items-center justify-center px-8 py-3">
                    <i class="fas fa-save mr-2"></i>
                    Simpan & Lanjutkan
                </button>
            </div>
        </form>
    </div>
</body>
</html>
