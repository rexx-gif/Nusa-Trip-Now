<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourPageController extends Controller
{
    /**
     * Menampilkan halaman daftar semua paket wisata.
     */
    public function index()
    {
        $tours = Tour::latest()->paginate(9); // Ambil 9 tur per halaman
        return view('tours.index', compact('tours'));
    }

    /**
     * Menampilkan halaman detail untuk satu paket wisata.
     */
    public function show(Tour $tour)
    {
        return view('tours.show', compact('tour'));
    }
}