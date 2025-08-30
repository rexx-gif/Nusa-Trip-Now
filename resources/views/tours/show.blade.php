<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tour->name }} - Detail Paket Wisata</title>
    <link rel="stylesheet" href="{{ asset('css/tour-details.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <main class="page-container">
        <div class="container">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L200.69,132H40a8,8,0,0,1,0-16H200.69L138.34,53.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z"></path></svg>
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