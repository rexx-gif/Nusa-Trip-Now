<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Get current month data
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Monthly revenue report
        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(booking_date) as month'),
                DB::raw('YEAR(booking_date) as year'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as bookings_count')
            )
            ->whereYear('booking_date', $currentYear)
            ->whereIn('status', ['paid', 'completed'])
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        // Popular tours
        $popularTours = Tour::withCount(['bookings' => function ($query) {
                $query->whereIn('status', ['paid', 'completed']);
            }])
            ->orderBy('bookings_count', 'desc')
            ->take(10)
            ->get();

        // User registration stats
        $userStats = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Booking status distribution
        $bookingStatusStats = Booking::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Recent bookings for detailed report
        $recentBookings = Booking::with(['user', 'tour', 'hotel'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return view('admin.reports.index', compact(
            'monthlyRevenue',
            'popularTours',
            'userStats',
            'bookingStatusStats',
            'recentBookings'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'monthly_revenue');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        switch ($type) {
            case 'bookings':
                return $this->exportBookings($startDate, $endDate);
            case 'users':
                return $this->exportUsers($startDate, $endDate);
            case 'revenue':
                return $this->exportRevenue($startDate, $endDate);
            default:
                return $this->exportMonthlyRevenue();
        }
    }

    private function exportMonthlyRevenue()
    {
        $currentYear = Carbon::now()->year;
        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(booking_date) as month'),
                DB::raw('YEAR(booking_date) as year'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(*) as bookings_count')
            )
            ->whereYear('booking_date', $currentYear)
            ->whereIn('status', ['paid', 'completed'])
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        $filename = "monthly_revenue_report_{$currentYear}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($monthlyRevenue) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Month', 'Year', 'Revenue', 'Bookings Count']);

            foreach ($monthlyRevenue as $month) {
                fputcsv($file, [
                    $month->month,
                    $month->year,
                    $month->revenue,
                    $month->bookings_count
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportBookings($startDate, $endDate)
    {
        $bookings = Booking::with(['user', 'tour', 'hotel'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->orderBy('booking_date', 'desc')
            ->get();

        $filename = "bookings_report_{$startDate}_to_{$endDate}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Tour', 'Hotel', 'Date', 'Quantity', 'Total Price', 'Status']);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->user ? $booking->user->name : 'N/A',
                    $booking->tour ? $booking->tour->name : 'N/A',
                    $booking->hotel ? $booking->hotel->name : 'N/A',
                    $booking->booking_date,
                    $booking->quantity,
                    $booking->total_price,
                    $booking->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportUsers($startDate, $endDate)
    {
        $users = User::whereBetween('created_at', [$startDate, $endDate])
            ->withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "users_report_{$startDate}_to_{$endDate}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Bookings Count', 'Created At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->bookings_count,
                    $user->created_at
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportRevenue($startDate, $endDate)
    {
        $revenue = Booking::select(
                'booking_date',
                DB::raw('SUM(total_price) as daily_revenue'),
                DB::raw('COUNT(*) as bookings_count')
            )
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->whereIn('status', ['paid', 'completed'])
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        $filename = "revenue_report_{$startDate}_to_{$endDate}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($revenue) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Revenue', 'Bookings Count']);

            foreach ($revenue as $day) {
                fputcsv($file, [
                    $day->booking_date,
                    $day->daily_revenue,
                    $day->bookings_count
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
