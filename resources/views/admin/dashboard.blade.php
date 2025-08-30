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
    <h3 class="text-2xl font-semibold mb-4">Live Chat</h3>
<div class="bg-white rounded-lg shadow-lg mb-8">
    <div class="flex h-[500px]"> <div class="w-1/3 border-r border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <h4 class="font-semibold text-gray-800">Percakapan Aktif</h4>
            </div>
            <ul id="active-users" class="overflow-y-auto h-[435px]">
                @forelse($chatUsers as $user)
                    <li class="p-4 cursor-pointer hover:bg-gray-100 border-b border-gray-200 user-chat-item" data-userid="{{ $user->id }}" data-username="{{ $user->name }}">
                        <p class="font-semibold text-gray-700">{{ $user->name }}</p>
                        </li>
                @empty
                    <p class="p-4 text-gray-500">Belum ada percakapan.</p>
                @endforelse
            </ul>
        </div>

        <div class="w-2/3 flex flex-col">
            <div id="chat-header" class="p-4 border-b border-gray-200">
                <h4 id="chat-with-user-name" class="font-semibold text-gray-800">Pilih percakapan untuk memulai</h4>
            </div>

            <div id="admin-chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50">
                <div class="text-center text-gray-400 mt-16">
                    <i class="fas fa-comments text-4xl"></i>
                    <p>Pilih user dari panel kiri untuk melihat percakapan.</p>
                </div>
            </div>

            <form id="admin-chat-form" class="p-4 border-t border-gray-200 bg-white hidden">
                <div class="flex">
                    <input type="hidden" id="admin-chat-user-id">
                    <input type="text" id="admin-chat-input" class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ketik balasan Anda..." autocomplete="off">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-r-md hover:bg-blue-600 font-semibold">
                        Kirim
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
    
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const userListItems = document.querySelectorAll('.user-chat-item');
    const chatMessagesContainer = document.getElementById('admin-chat-messages');
    const chatForm = document.getElementById('admin-chat-form');
    const chatHeader = document.getElementById('chat-with-user-name');
    const userIdInput = document.getElementById('admin-chat-user-id');
    const chatInput = document.getElementById('admin-chat-input');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let currentListeningUserId = null;

    // Tambahkan event listener untuk setiap user di daftar
    userListItems.forEach(item => {
        item.addEventListener('click', () => {
            const userId = item.dataset.userid;
            const userName = item.dataset.username;

            // Tandai item yang aktif
            userListItems.forEach(i => i.classList.remove('bg-blue-100'));
            item.classList.add('bg-blue-100');

            // Hanya load jika user yang dipilih berbeda
            if (currentListeningUserId !== userId) {
                loadChatForUser(userId, userName);
            }
        });
    });

    async function loadChatForUser(userId, userName) {
        // Hentikan listener di channel lama sebelum pindah
        if (currentListeningUserId) {
            window.Echo.leave(`livechat.${currentListeningUserId}`);
        }
        
        currentListeningUserId = userId;

        // Update UI
        chatHeader.textContent = `Percakapan dengan ${userName}`;
        chatMessagesContainer.innerHTML = '<p class="text-center text-gray-500">Memuat riwayat...</p>';
        userIdInput.value = userId;

        try {
            // Ambil riwayat dari server
            const response = await fetch(`/chat/history/${userId}`);
            const history = await response.json();

            chatMessagesContainer.innerHTML = ''; // Bersihkan pesan loading
            history.forEach(chat => {
                appendAdminMessage(chat.message, chat.sender);
            });

            chatForm.classList.remove('hidden'); // Tampilkan form balasan

            // Mulai dengarkan pesan real-time untuk user yang baru dipilih
            window.Echo.private(`livechat.${userId}`)
                .listen('NewChatMessage', (e) => {
                    // Pastikan pesan baru hanya muncul jika kita sedang melihat chat user yang benar
                    if (e.userId == currentListeningUserId) {
                        appendAdminMessage(e.message, e.sender);
                    } else {
                        // Optional: Beri notifikasi pada user di daftar kiri
                        const userItem = document.querySelector(`.user-chat-item[data-userid="${e.userId}"]`);
                        if (userItem) {
                            userItem.classList.add('animate-pulse'); // Contoh notifikasi
                        }
                    }
                });

        } catch (error) {
            console.error('Gagal memuat chat history:', error);
            chatMessagesContainer.innerHTML = '<p class="text-center text-red-500">Gagal memuat riwayat.</p>';
        }
    }

    // Fungsi untuk menampilkan pesan di dashboard
    function appendAdminMessage(message, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('p-2', 'rounded-lg', 'max-w-xs', 'mb-2');
        
        // Bedakan style pesan dari admin dan user
        if (sender === 'agent') {
            msgDiv.classList.add('bg-blue-500', 'text-white', 'ml-auto'); // Pesan admin di kanan
            msgDiv.textContent = message;
        } else {
            msgDiv.classList.add('bg-gray-200', 'text-gray-800', 'mr-auto'); // Pesan user di kiri
            msgDiv.textContent = message;
        }
        
        chatMessagesContainer.appendChild(msgDiv);
        chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight; // Auto-scroll
    }

    // Logika untuk form balasan admin
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        const userId = userIdInput.value;

        if (message && userId) {
            appendAdminMessage(message, 'agent'); // Tampilkan langsung di UI
            chatInput.value = ''; // Kosongkan input

            // Kirim via fetch ke endpoint admin
            fetch('/admin/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: message,
                    user_id: userId
                })
            }).catch(err => console.error('Gagal mengirim pesan:', err));
        }
    });

    // Fitur Tambahan: Dengarkan jika ada user baru yang memulai chat
    // Anda perlu membuat event dan channel baru untuk ini jika diinginkan
});
</script>
@endsection