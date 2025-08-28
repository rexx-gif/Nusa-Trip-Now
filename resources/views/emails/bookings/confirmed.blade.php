<x-mail::message>
# Pembayaran Dikonfirmasi!

Halo **{{ $booking->user->name }}**,

Kabar baik! Pembayaran Anda untuk paket wisata **{{ $booking->tour->name }}** telah berhasil kami konfirmasi.

**Detail Pesanan:**
- **Paket Wisata:** {{ $booking->tour->name }}
- **Tanggal Keberangkatan:** {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}
- **Total Pembayaran:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}

Terima kasih telah memilih kami. Kami tidak sabar untuk menyambut Anda dalam perjalanan yang tak terlupakan!

Salam Hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>