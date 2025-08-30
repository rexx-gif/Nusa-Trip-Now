<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ $booking->tour->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/payment-flow.css') }}">
</head>
<body style="background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ $imageUrl }}');">
    <div class="payment-container">
        <div class="timeline-container">
            <ol class="timeline">
                <li class="timeline-step done"><div class="step-circle">1</div><div class="step-label">Detail</div></li>
                <li class="timeline-step active"><div class="step-circle">2</div><div class="step-label">Bayar</div></li>
                <li class="timeline-step"><div class="step-circle">3</div><div class="step-label">Selesai</div></li>
            </ol>
        </div>

        <div class="payment-body">
            <div class="content-section">
                <h2>Selesaikan Pembayaran</h2>
                <p>Pesanan untuk <strong>{{ $booking->tour->name }}</strong></p>
            </div>

            <form action="{{ route('payment.upload', $booking) }}" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="summary-box payment-details">
                    <div class="summary-row summary-total">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="account-info">
                        <strong>Transfer ke Bank BCA:</strong>
                        <p>No. Rek: 123-456-7890 (PT Wisata Nusantara)</p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="proof_of_payment">Unggah Bukti Pembayaran</label>
                    <input type="file" name="proof_of_payment" id="proof_of_payment" required>
                    @error('proof_of_payment')
                        <span class="error-message" style="color: #f00; font-size: 0.8rem;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="button-group">
                    <a href="{{ route('home') }}" class="btn btn-secondary">Bayar Nanti</a>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>