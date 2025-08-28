<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilihan Paket Wisata - {{ config('app.name', 'Laravel') }}</title>

    {{-- Menghubungkan ke file CSS --}}
    <link rel="stylesheet" href="{{ asset('css/tour.css') }}">
    
    {{-- Menghubungkan ke font dari Google Fonts untuk tampilan yang lebih baik --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <header class="page-section">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">
                    {{ __('Pilihan Paket Wisata') }}
                </h1>
                <p class="page-subtitle">
                    Jelajahi destinasi impian Anda dengan penawaran terbaik dari kami.
                </p>
            </div>
        </div>
    </header>

    <main class="page-section">
        <div class="container">
            <div class="tour-grid">
                @forelse ($tours as $tour)
                    <div class="tour-card">
                        <a href="{{ route('tours.show', $tour) }}" class="tour-card-link">
                            <div class="tour-card-image-wrapper">
                                <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="tour-card-image">
                            </div>
                        </a>
                        <div class="tour-card-content">
                            <h3 class="tour-card-title">
                                <a href="{{ route('tours.show', $tour) }}">{{ $tour->name }}</a>
                            </h3>
                            
                            <div class="tour-card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $tour->location }}</span>
                            </div>

                            <div class="tour-card-footer">
                                <p class="tour-card-price-label">Mulai dari</p>
                                <p class="tour-card-price">
                                    Rp {{ number_format($tour->price, 0, ',', '.') }}
                                </p>
                                
                                <a href="{{ route('tours.show', $tour) }}" class="btn">
                                    Lihat Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg class="empty-state-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="empty-state-title">Paket Wisata Tidak Ditemukan</h3>
                        <p class="empty-state-text">Belum ada paket wisata yang tersedia saat ini. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse
            </div>

            @if ($tours->hasPages())
                <div class="pagination-wrapper">
                    {{-- Laravel's default pagination HTML will be styled by tour.css --}}
                    {{ $tours->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>