@extends('layouts.payment')

@section('title', 'Proses Pembayaran')

@section('content')
    @php
        $isWaitingPayment = $booking->status == 'waiting_payment';
        $isPendingConfirmation = $booking->status == 'pending_confirmation';
        $isPaid = $booking->status == 'paid';
    @endphp

    <!-- Timeline -->
    <ol class="timeline">
        <li class="timeline-step completed">
            <div class="step-circle">1</div>
            <div class="step-label">Detail Pesanan</div>
        </li>
        <li class="timeline-step {{ $isWaitingPayment ? 'active' : '' }} {{ $isPendingConfirmation || $isPaid ? 'completed' : '' }}">
            <div class="step-circle">2</div>
            <div class="step-label">Pembayaran</div>
        </li>
        <li class="timeline-step {{ $isPaid ? 'active' : '' }}">
            <div class="step-circle">3</div>
            <div class="step-label">Selesai</div>
        </li>
    </ol>

    <!-- Konten Dinamis -->
    @if($isWaitingPayment)
        <div class="content-section">
            <h2>Selesaikan Pembayaran</h2>
            <p>
                Pesanan Anda untuk <strong>{{ $booking->quantity }} tiket</strong> {{ $booking->tour->name }} telah kami terima.
                Silakan lakukan pembayaran sejumlah <strong style="color:#3b82f6;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong> ke salah satu rekening berikut:
            </p>
        </div>
        <div class="payment-info-box" style="display:flex; gap: 20px; text-align:center; justify-content: center;">
            <div>
                <p><strong>Bank BCA</strong><br>1234567890<br>a.n. PT NusaTripNow</p>
            </div>
            <div>
                <p><strong>Bank Mandiri</strong><br>0987654321<br>a.n. PT NusaTripNow</p>
            </div>
        </div>
        <hr style="margin: 24px 0; border-color:#eee;">
        <form action="{{ route('payment.upload', $booking) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="proof_of_payment">Upload Bukti Pembayaran:</label>
                <input type="file" name="proof_of_payment" id="proof_of_payment" required>
                @error('proof_of_payment') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
            </div>
        </form>
    @elseif($isPendingConfirmation)
        <div class="centered-content">
            <div class="icon">✓</div>
            <h2>Terima Kasih!</h2>
            <p>Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi oleh tim kami. Mohon tunggu 1x24 jam.</p>
            <a href="{{ route('user.profile.history') }}" class="btn btn-primary">Kembali ke Riwayat Pesanan</a>
        </div>
    @elseif($isPaid)
        <div class="centered-content">
            <div class="icon">🎉</div>
            <h2>Pembayaran Dikonfirmasi!</h2>
            <p>Pemesanan Anda telah lunas. Selamat menikmati perjalanan Anda!</p>
            <a href="{{ route('user.profile.history') }}" class="btn btn-primary">Kembali ke Riwayat Pesanan</a>
        </div>
    @endif
@endsection
