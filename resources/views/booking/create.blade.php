@extends('layouts.payment')

@section('title', 'Formulir Pemesanan')

@section('content')
    <!-- Timeline -->
    <ol class="timeline">
        <li class="timeline-step active">
            <div class="step-circle">1</div>
            <div class="step-label">Detail Pesanan</div>
        </li>
        <li class="timeline-step">
            <div class="step-circle">2</div>
            <div class="step-label">Pembayaran</div>
        </li>
        <li class="timeline-step">
            <div class="step-circle">3</div>
            <div class="step-label">Selesai</div>
        </li>
    </ol>

    <div class="content-section">
        <h2>{{ $tour->name }}</h2>
        <p>{{ $tour->location }}</p>
    </div>

    <form action="{{ route('booking.store', $tour) }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="booking_date">Pilih Tanggal Keberangkatan</label>
                <input type="date" name="booking_date" id="booking_date" min="{{ now()->toDateString() }}" value="{{ old('booking_date') }}" required>
                @error('booking_date') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah Tiket</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="10" required>
                @error('quantity') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>
        
        <div class="summary-box">
            <div class="summary-row">
                <span>Harga per tiket</span>
                <span id="price-per-ticket">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
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
            <button type="submit" class="btn btn-primary">Lanjutkan ke Pembayaran</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const ticketCountSpan = document.getElementById('ticket-count');
            const totalPriceSpan = document.getElementById('total-price');
            const pricePerTicket = {{ $tour->price }};

            quantityInput.addEventListener('input', function() {
                let quantity = parseInt(this.value);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                }
                
                const totalPrice = pricePerTicket * quantity;

                ticketCountSpan.textContent = quantity;
                totalPriceSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            });
        });
    </script>
@endsection