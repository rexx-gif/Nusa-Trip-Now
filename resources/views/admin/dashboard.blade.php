@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p class="font-bold">Sukses</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow">
            <h3 class="text-lg font-semibold">Total Penjualan</h3>
            <p class="text-2xl font-bold">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- BAGIAN BARU: Tabel Konfirmasi Pembayaran -->
    <h3 class="text-2xl font-semibold mb-4">Menunggu Konfirmasi Pembayaran</h3>
    <div class="overflow-x-auto bg-white rounded-lg shadow mb-8">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">User</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Paket Wisata</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Bukti Transfer</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse($pendingConfirmations as $booking)
                <tr>
                    <td class="py-3 px-4">{{ $booking->user->name }}</td>
                    <td class="py-3 px-4">{{ $booking->tour->name }}</td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ asset('storage/' . $booking->proof_of_payment) }}" target="_blank" class="text-blue-500 hover:underline">
                            Lihat Bukti
                        </a>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?');">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md text-xs font-semibold hover:bg-green-600">
                                Approve
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada pembayaran yang menunggu konfirmasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel History Penyewaan (yang sudah ada sebelumnya) -->
    <h3 class="text-2xl font-semibold mb-4">History Semua Penyewaan</h3>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <!-- Kode tabel history Anda yang sudah ada sebelumnya diletakkan di sini -->
        <table class="min-w-full">
             <thead class="bg-gray-200">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">User</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Paket Wisata</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Tanggal</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse($allBookings as $booking)
                <tr>
                    <td class="py-3 px-4">{{ $booking->user->name }}</td>
                    <td class="py-3 px-4">{{ $booking->tour->name }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($booking->status == 'paid' || $booking->status == 'completed') bg-green-200 text-green-800
                            @elseif($booking->status == 'pending_confirmation') bg-orange-200 text-orange-800
                            @elseif($booking->status == 'waiting_payment') bg-yellow-200 text-yellow-800
                            @else bg-red-200 text-red-800 @endif">
                            {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Belum ada data penyewaan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $allBookings->links() }}
        </div>
    </div>
@endsection