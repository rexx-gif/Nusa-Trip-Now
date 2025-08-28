<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Berhasil</title>
    <link rel="stylesheet" href="{{ asset('css/payment-flow.css') }}">
</head>
<body>

    <div class="payment-container">
        <ol class="timeline">
            <li class="timeline-step completed">
                <div class="step-circle">1</div>
                <div class="step-label">Detail Pesanan</div>
            </li>
            <li class="timeline-step completed">
                <div class="step-circle">2</div>
                <div class="step-label">Pembayaran</div>
            </li>
            <li class="timeline-step active">
                <div class="step-circle">3</div>
                <div class="step-label">Selesai</div>
            </li>
        </ol>

        <div class="centered-content">
            <div class="icon">🎉</div>
            <h2>Pemesanan Berhasil Dikonfirmasi!</h2>
            @if(session('success_message'))
                <p>{{ session('success_message') }}</p>
            @else
                <p>Pemesanan Anda telah berhasil. Detail pemesanan telah kami kirimkan ke email Anda.</p>
            @endif
            <div class="button-group" style="justify-content: center;">
                <a href="{{ route('tours.index') }}" class="btn btn-secondary">Jelajahi Wisata Lain</a>
                <a href="{{ route('user.profile.history') }}" class="btn btn-primary">Lihat Riwayat Pesanan</a>
            </div>
        </div>
    </div>

</body>
</html>