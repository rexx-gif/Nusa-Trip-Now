<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tour->name }} - Detail Paket Wisata</title>

    {{-- Menghubungkan ke file CSS untuk halaman detail --}}
    <link rel="stylesheet" href="{{ asset('css/tour-details.css') }}">
    
    {{-- (Opsional) Menghubungkan ke font dari Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <main class="page-container">
        <div class="container">
            {{-- Tombol Kembali (Opsional tapi direkomendasikan untuk UX) --}}
            <div class="back-link-wrapper">
                <a href="{{ route('tours.index') }}" class="back-link">&larr; Kembali ke semua paket</a>
            </div>

            <div class="tour-detail-card">
                <div class="tour-detail-grid">
                    
                    <div class="tour-image-container">
                        <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="tour-image">
                    </div>

                    <div class="tour-content-container">
                        <div class="tour-info">
                            <p class="tour-location">{{ $tour->location }}</p>
                            <h1 class="tour-title">{{ $tour->name }}</h1>
                            <p class="tour-description">
                                {{ $tour->description }}
                            </p>
                        </div>
                        
                        <div class="booking-box">
                            <div class="price-section">
                                <p class="price-label">Harga mulai dari</p>
                                <p class="price-amount">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="booking-action">
                                <a href="{{ route('booking.create', $tour) }}" class="btn-booking">
                                    Booking Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>