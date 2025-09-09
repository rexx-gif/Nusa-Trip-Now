@extends('layouts.admin-dashboard')

@section('page-title', 'Laporan & Analitik')

@section('page-content')
<!-- Alert Notification -->
@if(session('success'))
<div class="alert">
    <p class="alert-title">Sukses!</p>
    <p>{{ session('success') }}</p>
</div>
@endif

<!-- Export Actions -->
<div class="card">
    <h3 class="card-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export Laporan
    </h3>
    <div class="export-actions">
        <button class="btn btn-primary" onclick="exportReport('monthly_revenue')">
            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Export Pendapatan Bulanan</span>
        </button>
        <button class="btn btn-success" onclick="exportReport('bookings')">
            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Export Data Booking</span>
        </button>
        <button class="btn btn-warning" onclick="exportReport('users')">
            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <span>Export Data User</span>
        </button>
    </div>
</div>

<!-- Revenue Analytics -->
<div class="card chart-card">
    <h3 class="card-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Analitik Pendapatan {{ date('Y') }}
    </h3>
    <div class="chart-container">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Revenue Stats Grid -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-content">
            <p class="stat-title">Total Pendapatan</p>
            <p class="stat-value">Rp {{ number_format($monthlyRevenue->sum('revenue'), 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div class="stat-content">
            <p class="stat-title">Rata-rata per Bulan</p>
            <p class="stat-value">Rp {{ number_format($monthlyRevenue->avg('revenue'), 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
        </div>
        <div class="stat-content">
            <p class="stat-title">Bulan Terbaik</p>
            <p class="stat-value">{{ $monthlyRevenue->sortByDesc('revenue')->first() ? \Carbon\Carbon::create()->month($monthlyRevenue->sortByDesc('revenue')->first()->month)->format('M') : 'N/A' }}</p>
        </div>
    </div>

    <div class="card stat-card">
        <div class="stat-icon-wrapper">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div class="stat-content">
            <p class="stat-title">User Terdaftar</p>
            <p class="stat-value">{{ $userStats->sum('count') }}</p>
        </div>
    </div>
</div>

<!-- Popular Tours Performance -->
<div class="card">
    <h3 class="card-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Performansi Wisata Terpopuler
    </h3>

    <div class="table-container">
        <table class="data-table">
            <thead class="table-header">
                <tr>
                    <th>Nama Wisata</th>
                    <th>Jumlah Booking</th>
                    <th>Pendapatan</th>
                    <th>Harga Rata-rata</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($popularTours as $tour)
                <tr class="table-row">
                    <td>{{ $tour->name }}</td>
                    <td>{{ $tour->bookings_count }}</td>
                    <td>Rp {{ number_format($tour->bookings_count * $tour->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($tour->price, 0, ',', '.') }}</td>
                    <td>
                        @if($tour->is_active)
                            <span class="status-badge status-paid">Aktif</span>
                        @else
                            <span class="status-badge status-cancelled">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="table-row">
                    <td colspan="5" class="text-center">
                        <div class="empty-state">
                            <p>Belum ada data wisata</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- User Registration Trends -->
<div class="card">
    <h3 class="card-title">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        Tren Registrasi User
    </h3>

    <div class="table-container">
        <table class="data-table">
            <thead class="table-header">
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah Registrasi</th>
                    <th>Akumulasi</th>
                    <th>Persentase Pertumbuhan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalUsers = 0;
                    $previousMonth = 0;
                @endphp
                @foreach($userStats as $stat)
                @php
                    $totalUsers += $stat->count;
                    $growth = $previousMonth > 0 ? (($stat->count - $previousMonth) / $previousMonth) * 100 : 0;
                    $previousMonth = $stat->count;
                @endphp
                <tr class="table-row">
                    <td>{{ \Carbon\Carbon::create()->month($stat->month)->format('F Y') }}</td>
                    <td>{{ $stat->count }}</td>
                    <td>{{ $totalUsers }}</td>
                    <td>
                        @if($growth > 0)
                            <span class="growth-positive">+{{ number_format($growth, 1) }}%</span>
                        @elseif($growth < 0)
                            <span class="growth-negative">{{ number_format($growth, 1) }}%</span>
                        @else
                            <span class="growth-neutral">0%</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const monthlyData = @json($monthlyRevenue);
        const labels = [];
        const data = [];

        // Create labels for all 12 months
        for (let i = 1; i <= 12; i++) {
            labels.push(new Date(2024, i - 1, 1).toLocaleDateString('id-ID', { month: 'short' }));
            const monthData = monthlyData.find(item => item.month == i);
            data.push(monthData ? monthData.revenue : 0);
        }

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: data,
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderColor: 'rgba(245, 158, 11, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(245, 158, 11, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: { drawBorder: false }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});

function exportReport(type) {
    const url = '{{ route("admin.reports.export") }}?type=' + type;
    window.open(url, '_blank');
}
</script>

<style>
    /* Additional styles for reports page */
    .status-paid {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-waiting {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .export-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 16px;
    }

    .export-actions button {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .export-actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .growth-positive {
        color: #16a34a;
        font-weight: 600;
    }

    .growth-negative {
        color: #dc2626;
        font-weight: 600;
    }

    .growth-neutral {
        color: #6b7280;
        font-weight: 600;
    }
</style>
@endsection
