<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - {{ $tour->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/payment-flow.css') }}">
    <style>
        .hotel-selection-section {
            margin: 2rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .hotel-selection-section h3 {
            margin-bottom: 1.5rem;
            color: #1a202c;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .hotel-options {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hotel-option {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .hotel-option:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
        }

        .hotel-option input[type="radio"] {
            margin-top: 0.25rem;
            accent-color: #667eea;
        }

        .hotel-option label {
            flex: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .hotel-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .hotel-name {
            font-weight: 600;
            color: #1a202c;
            font-size: 1rem;
        }

        .hotel-location {
            font-size: 0.85rem;
            color: #718096;
        }

        .hotel-price {
            font-size: 0.9rem;
            color: #2b6cb0;
            font-weight: 500;
        }

        .hotel-option:has(input[type="radio"]:checked) {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .hotel-option input[type="hidden"] {
            display: none;
        }

        @media (max-width: 768px) {
            .hotel-selection-section {
                padding: 1rem;
            }

            .hotel-option {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ Storage::url($tour->image) }}');">
    <div class="payment-container">
        <div class="timeline-container">
            <ol class="timeline">
                <li class="timeline-step active"><div class="step-circle">1</div><div class="step-label">Detail</div></li>
                <li class="timeline-step"><div class="step-circle">2</div><div class="step-label">Bayar</div></li>
                <li class="timeline-step"><div class="step-circle">3</div><div class="step-label">Selesai</div></li>
            </ol>
        </div>

        <div class="payment-body">
            <div class="content-section">
                <h2>{{ $tour->name }}</h2>
                <p>{{ $tour->location }}</p>
            </div>

            @php
                $provinceHotels = \App\Models\Hotel::where('province_id', $tour->province_id)->get();
                $withHotel = request('with_hotel', false);
            @endphp

            <form action="{{ route('booking.store', $tour) }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="booking_date">Tanggal Berangkat</label>
                        <input type="date" name="booking_date" id="booking_date" min="{{ now()->toDateString() }}" value="{{ old('booking_date') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah Tiket</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="10" required>
                    </div>
                </div>

                <!-- Hotel Selection -->
                @if($provinceHotels->count() > 0)
                    <div class="hotel-selection-section">
                        <h3>Pilih Penginapan</h3>
                        <div class="hotel-options">
                            <div class="hotel-option">
                                <input type="radio" id="no_hotel" name="with_hotel" value="0" {{ !$withHotel ? 'checked' : '' }}>
                                <label for="no_hotel">
                                    <div class="hotel-info">
                                        <span class="hotel-name">Wisata Saja</span>
                                        <span class="hotel-price">Rp {{ number_format($tour->price, 0, ',', '.') }} per orang</span>
                                    </div>
                                </label>
                            </div>

                            @foreach($provinceHotels->take(3) as $hotel)
                                <div class="hotel-option">
                                    <input type="radio" id="hotel_{{ $hotel->id }}" name="with_hotel" value="1" {{ $withHotel ? 'checked' : '' }}>
                                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                    <label for="hotel_{{ $hotel->id }}">
                                        <div class="hotel-info">
                                            <span class="hotel-name">{{ $hotel->name }}</span>
                                            <span class="hotel-location">{{ $hotel->city ? $hotel->city . ', ' : '' }}{{ $tour->province->name }}</span>
                                            <span class="hotel-price">Rp {{ number_format($hotel->price, 0, ',', '.') }} per malam</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div class="summary-box">
                    <div class="summary-row">
                        <span>Harga per tiket</span>
                        <span>Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Jumlah Tiket</span>
                        <span id="ticket-count">1</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total Pembayaran</span>
                        <span id="total-price">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ route('tours.show', $tour) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Lanjutkan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const ticketCountSpan = document.getElementById('ticket-count');
            const totalPriceSpan = document.getElementById('total-price');
            const pricePerTicket = {{ $tour->price }};
            const hotelRadios = document.querySelectorAll('input[name="with_hotel"]');

            function updateSummary() {
                let quantity = parseInt(quantityInput.value) || 1;
                quantity = Math.max(1, Math.min(10, quantity));
                quantityInput.value = quantity;
                ticketCountSpan.textContent = quantity;

                // Calculate base price
                let totalPrice = pricePerTicket * quantity;

                // Add hotel price if selected
                const selectedHotelRadio = document.querySelector('input[name="with_hotel"]:checked');
                if (selectedHotelRadio && selectedHotelRadio.value === '1') {
                    const hotelOption = selectedHotelRadio.closest('.hotel-option');
                    const hotelPriceText = hotelOption.querySelector('.hotel-price').textContent;
                    const hotelPrice = parseInt(hotelPriceText.replace(/[^\d]/g, '')) || 0;
                    // Assume 2 nights for hotel stay
                    totalPrice += hotelPrice * 2 * quantity;
                }

                totalPriceSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            }

            quantityInput.addEventListener('input', updateSummary);

            // Handle hotel selection changes
            hotelRadios.forEach(radio => {
                radio.addEventListener('change', updateSummary);
            });

            updateSummary();
        });
    </script>
</body>
</html>