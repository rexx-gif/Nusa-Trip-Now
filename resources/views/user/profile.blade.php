<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Riwayat Pesanan Saya</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="page-container">
        <div class="container">
            <header class="page-header">
                <h1>Profil & Riwayat Pesanan Saya</h1>
            </header>

            <div class="profile-grid">
                <aside class="profile-sidebar">
                    <div class="sidebar-content">
                        <div class="avatar">
                            <svg class="avatar-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h2 class="user-name">{{ $user->name }}</h2>
                        <p class="user-email">{{ $user->email }}</p>

                        <div class="profile-actions">
                             <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                <section class="profile-content">
                    <div class="content-card">
                        <h3 class="content-title">Riwayat Pesanan</h3>
                        
                        <div class="table-wrapper">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>Paket Wisata</th>
                                        <th>Tanggal</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bookings as $booking)
                                        <tr>
                                            <td data-label="Paket Wisata">
                                                <div class="tour-name">{{ $booking->tour->name }}</div>
                                                <div class="tour-location">{{ $booking->tour->location }}</div>
                                            </td>
                                            <td data-label="Tanggal">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('D MMMM YYYY') }}
                                            </td>
                                            <td data-label="Total Harga">
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </td>
                                            <td data-label="Status">
                                                @php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($booking->status) {
                                                        case 'paid':
                                                        case 'completed':
                                                            $statusClass = 'status-paid';
                                                            $statusText = 'Lunas';
                                                            break;
                                                        case 'pending_confirmation':
                                                            $statusClass = 'status-pending';
                                                            $statusText = 'Menunggu Konfirmasi';
                                                            break;
                                                        case 'waiting_payment':
                                                            $statusClass = 'status-waiting';
                                                            $statusText = 'Menunggu Pembayaran';
                                                            break;
                                                        default:
                                                            $statusClass = 'status-cancelled';
                                                            $statusText = 'Dibatalkan';
                                                    }
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                            <td data-label="Aksi">
                                                @if($booking->status == 'waiting_payment')
                                                    <a href="{{ route('payment.show', $booking) }}" class="action-link">Bayar</a>
                                                @else
                                                    <a href="{{ route('tours.show', $booking->tour) }}" class="action-link action-link-secondary">Lihat</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state">
                                                    <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                    </svg>
                                                    <h3 class="empty-state-title">Belum Ada Pesanan</h3>
                                                    <p class="empty-state-text">Mulai jelajahi dan pesan paket wisata impian Anda.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="pagination-wrapper">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

</body>
</html>