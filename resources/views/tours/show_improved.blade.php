<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tour->name }} - Detail Paket Wisata</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<main class="tour-detail-page dark-theme">
    <!-- Hero Section -->
    <section class="tour-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-breadcrumb">
                    <a href="{{ route('tours.index') }}" class="breadcrumb-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Wisata
                    </a>
                </div>
                <h1 class="hero-title">{{ $tour->name }}</h1>
                <p class="hero-location">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $tour->location }}, {{ $tour->province->name }}
                </p>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}">
        </div>
    </section>

    <!-- Main Content -->
    <section class="tour-content-section">
        <div class="container">
            <div class="tour-content-grid">

                <!-- Left Column - Tour Details -->
                <div class="tour-details-column">

                    <!-- Tour Description -->
                    <div class="content-card">
                        <h2 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Deskripsi Wisata
                        </h2>
                        <div class="tour-description">
                            <p>{{ $tour->description }}</p>
                        </div>
                    </div>

                    <!-- Categories -->
                    @if($tour->categories->count() > 0)
                        <div class="content-card">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Kategori Wisata
                            </h2>
                            <div class="categories-grid">
                                @foreach($tour->categories as $category)
                                    <span class="category-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Inclusions -->
                    @if($tour->inclusions->count() > 0)
                        <div class="content-card">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Fasilitas yang Termasuk
                            </h2>
                            <div class="inclusions-grid">
                                @foreach($tour->inclusions as $inclusion)
                                    <div class="inclusion-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $inclusion->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Right Column - Booking & Hotels -->
                <div class="booking-column">

                    <!-- Booking Card -->
                    <div class="booking-card">
                        <div class="booking-header">
                            <h3>Pesan Sekarang</h3>
                            <div class="price-display">
                                <span class="price-label">Harga mulai dari</span>
                                <span class="price-amount">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                                <span class="price-unit">per orang</span>
                            </div>
                        </div>

                        <div class="booking-info">
                            <div class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Durasi: 2-3 hari</span>
                            </div>
                            <div class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Min. 2 orang</span>
                            </div>
                            <div class="info-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Include: {{$tour->inclusions->count()}} fasilitas</span>
                            </div>
                        </div>

                        <div class="booking-actions">
                            <a href="{{ route('booking.create', $tour) }}" class="btn-booking-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1 5M7 13L5.4 5" />
                                </svg>
                                Pesan Wisata Ini
                            </a>
                            <p class="booking-note">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Gratis konsultasi sebelum booking
                            </p>
                        </div>
                    </div>

                    <!-- Hotel Selection -->
                    @php
                        $provinceHotels = \App\Models\Hotel::where('province_id', $tour->province_id)->get();
                    @endphp

                    @if($provinceHotels->count() > 0)
                        <div class="hotel-selection-card">
                            <h3 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Pilih Hotel di {{ $tour->province->name }}
                            </h3>
                            <p class="card-subtitle">Tambahkan penginapan untuk melengkapi paket wisata Anda</p>

                            <!-- Hotel Selection Toggle -->
                            <div class="hotel-toggle-section">
                                <div class="toggle-option">
                                    <input type="radio" id="no-hotel" name="hotel_choice" value="no" checked>
                                    <label for="no-hotel">
                                        <div class="toggle-content">
                                            <div class="toggle-header">
                                                <span class="toggle-title">Wisata Saja</span>
                                                <span class="toggle-price">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                                            </div>
                                            <p class="toggle-description">Paket wisata tanpa penginapan</p>
                                        </div>
                                    </label>
                                </div>

                                <div class="toggle-option">
                                    <input type="radio" id="with-hotel" name="hotel_choice" value="yes">
                                    <label for="with-hotel">
                                        <div class="toggle-content">
                                            <div class="toggle-header">
                                                <span class="toggle-title">Wisata + Hotel</span>
                                                <span class="toggle-price">Rp {{ number_format($tour->price + ($provinceHotels->first()->price * 2), 0, ',', '.') }}</span>
                                            </div>
                                            <p class="toggle-description">Paket wisata dengan penginapan 2 malam</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Hotel Options (shown when "with hotel" is selected) -->
                            <div class="hotel-options" id="hotel-options" style="display: none;">
                                @foreach($provinceHotels->take(3) as $hotel)
                                    <div class="hotel-option">
                                        <div class="hotel-info">
                                            <h4>{{ $hotel->name }}</h4>
                                            <p class="hotel-location">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $hotel->city ? $hotel->city . ', ' : '' }}{{ $tour->province->name }}
                                            </p>
                                            <p class="hotel-description">{{ Str::limit($hotel->description ?? 'Hotel dengan fasilitas lengkap', 60) }}</p>
                                        </div>
                                        <div class="hotel-price">
                                            <span class="price-amount">Rp {{ number_format($hotel->price, 0, ',', '.') }}</span>
                                            <span class="price-unit">/malam</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="hotel-total" id="hotel-total" style="display: none;">
                                <div class="total-row">
                                    <span>Harga Wisata</span>
                                    <span>Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="total-row">
                                    <span>Harga Hotel (2 malam)</span>
                                    <span id="hotel-price-display">Rp {{ number_format($provinceHotels->first()->price * 2, 0, ',', '.') }}</span>
                                </div>
                                <div class="total-row total-grand">
                                    <span>Total Estimasi</span>
                                    <span id="total-price-display">Rp {{ number_format($tour->price + ($provinceHotels->first()->price * 2), 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="booking-actions">
                                <button type="button" id="book-now-btn" class="btn-booking-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1 5M7 13L5.4 5" />
                                    </svg>
                                    Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>
</main>

<style>
/* Tour Detail Page Styles */
.tour-detail-page {
    min-height: 100vh;
}

/* Hero Section */
.tour-hero {
    position: relative;
    height: 60vh;
    overflow: hidden;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    align-items: center;
    color: white;
}

.hero-breadcrumb {
    margin-bottom: 2rem;
}

.breadcrumb-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: white;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
    opacity: 0.9;
}

.hero-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Content Section */
.tour-content-section {
    padding: 4rem 0;
    background: #1a1a1a;
}

.tour-content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
    align-items: start;
}

.tour-details-column {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.booking-column {
    position: sticky;
    top: 2rem;
}

/* Content Cards */
.content-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.5rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 1.5rem;
}

.tour-description {
    line-height: 1.7;
    color: #4a5568;
    font-size: 1.1rem;
}

/* Categories */
.categories-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #e6f3ff;
    color: #0066cc;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Inclusions */
.inclusions-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

.inclusion-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f7fafc;
    border-radius: 8px;
    color: #2d3748;
    font-weight: 500;
}

.inclusion-item svg {
    color: #48bb78;
    flex-shrink: 0;
}

/* Booking Card */
.booking-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border: 1px solid #e2e8f0;
}

.booking-header {
    text-align: center;
    margin-bottom: 2rem;
}

.booking-header h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 1rem;
}

.price-display {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.price-label {
    font-size: 0.9rem;
    color: #718096;
}

.price-amount {
    font-size: 2rem;
    font-weight: 700;
    color: #2b6cb0;
}

.price-unit {
    font-size: 0.9rem;
    color: #718096;
}

.booking-info {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    color: #4a5568;
    font-size: 0.95rem;
}

.info-item svg {
    color: #718096;
    flex-shrink: 0;
}

.booking-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-booking-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-booking-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.booking-note {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #718096;
    text-align: center;
    justify-content: center;
}

/* Hotel Selection Card */
.hotel-selection-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 2rem;
}

.hotel-selection-card .card-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.card-subtitle {
    color: #718096;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

.hotel-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.hotel-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f7fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.hotel-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 0.25rem;
}

.hotel-location {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.85rem;
    color: #718096;
    margin-bottom: 0.25rem;
}

.hotel-description {
    font-size: 0.85rem;
    color: #4a5568;
    line-height: 1.4;
}

.hotel-price {
    text-align: right;
    flex-shrink: 0;
}

.hotel-price .price-amount {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2b6cb0;
    display: block;
}

.hotel-price .price-unit {
    font-size: 0.8rem;
    color: #718096;
}

.hotel-total {
    background: #f7fafc;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    color: #4a5568;
}

.total-row:last-child {
    margin-bottom: 0;
}

.total-grand {
    border-top: 1px solid #e2e8f0;
    padding-top: 0.75rem;
    font-weight: 600;
    color: #1a202c;
    font-size: 1rem;
}

.btn-booking-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #48bb78;
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    width: 100%;
    transition: background-color 0.2s ease;
}

.btn-booking-secondary:hover {
    background: #38a169;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .tour-content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .booking-column {
        position: static;
    }

    .hero-title {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }

    .tour-content-section {
        padding: 2rem 0;
    }

    .content-card {
        padding: 1.5rem;
    }

    .booking-card {
        padding: 1.5rem;
    }

    .hotel-selection-card {
        padding: 1.5rem;
    }

    .hotel-option {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .hotel-price {
        text-align: left;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hotelRadios = document.querySelectorAll('input[name="hotel_choice"]');
    const hotelOptions = document.getElementById('hotel-options');
    const hotelTotal = document.getElementById('hotel-total');
    const bookNowBtn = document.getElementById('book-now-btn');

    hotelRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'yes') {
                hotelOptions.style.display = 'flex';
                hotelTotal.style.display = 'block';
                bookNowBtn.textContent = 'Pesan dengan Hotel';
            } else {
                hotelOptions.style.display = 'none';
                hotelTotal.style.display = 'none';
                bookNowBtn.textContent = 'Pesan Wisata Saja';
            }
        });
    });

    // Handle booking button click
    bookNowBtn.addEventListener('click', function() {
        const selectedChoice = document.querySelector('input[name="hotel_choice"]:checked').value;
        const tourId = {{ $tour->id }};
        let url = '{{ route("booking.create", ":tourId") }}'.replace(':tourId', tourId);

        if (selectedChoice === 'yes') {
            url += '?with_hotel=1';
        }

        window.location.href = url;
    });
});
</script>
</body>
</html>
