<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - {{ $tour->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/payment-flow.css') }}">
</head>
<body style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ Storage::url($tour->image) }}');">    <div class="payment-container">
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
            function updateSummary() {
                let quantity = parseInt(quantityInput.value) || 1;
                quantity = Math.max(1, Math.min(10, quantity));
                quantityInput.value = quantity;
                ticketCountSpan.textContent = quantity;
                totalPriceSpan.textContent = 'Rp ' + (pricePerTicket * quantity).toLocaleString('id-ID');
            }
            quantityInput.addEventListener('input', updateSummary);
            updateSummary();
        });
    </script>
</body>
</html>