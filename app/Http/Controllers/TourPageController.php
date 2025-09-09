<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourPageController extends Controller
{
    /**
     * Menampilkan halaman daftar semua paket wisata.
     */
    public function index(Request $request)
    {
        $query = Tour::with(['province', 'categories', 'inclusions', 'hotels']);

        // Filter by province
        if ($request->filled('province')) {
            $query->where('province_id', $request->province);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filter by inclusion
        if ($request->filled('inclusion')) {
            $query->whereHas('inclusions', function($q) use ($request) {
                $q->where('inclusions.id', $request->inclusion);
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by name or location
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $tours = $query->latest()->paginate(9);

        // Get filter data
        $provinces = \App\Models\Province::all();
        $categories = \App\Models\Category::all();
        $inclusions = \App\Models\Inclusion::all();
        $hotels = \App\Models\Hotel::all();

        return view('tours.index', compact('tours', 'provinces', 'categories', 'inclusions', 'hotels'));
    }

    /**
     * Menampilkan halaman detail untuk satu paket wisata.
     */
    public function show(Tour $tour)
    {
        $tour->load(['province', 'categories', 'inclusions', 'hotels']);
        return view('tours.show', compact('tour'));
    }
}