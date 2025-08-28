@extends('layouts.admin')

@section('title', 'Manajemen Wisata')

@section('content')
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.tours.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            + Tambah Wisata Baru
        </a>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p class="font-bold">Sukses</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Wisata</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tours as $tour)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="h-16 w-24 object-cover rounded-md">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $tour->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $tour->location }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">Rp {{ number_format($tour->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <a href="{{ route('admin.tours.edit', $tour) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket wisata ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        Belum ada data paket wisata. Silakan tambahkan data baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-6">
        {{ $tours->links() }}
    </div>
@endsection