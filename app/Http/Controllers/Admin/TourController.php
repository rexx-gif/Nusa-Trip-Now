<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TourController extends Controller
{
    // Menampilkan semua data wisata
    public function index()
    {
        $tours = Tour::with(['province', 'categories', 'inclusions', 'hotels'])->latest()->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    // Menampilkan form tambah wisata
    public function create()
    {
        $tours = Tour::with(['province', 'categories', 'inclusions', 'hotels'])->latest()->paginate(10);
        $provinces = \App\Models\Province::all();
        $categories = \App\Models\Category::all();
        $inclusions = \App\Models\Inclusion::all();
        $hotels = \App\Models\Hotel::all();
        return view('admin.tours.create', compact('tours', 'provinces', 'categories', 'inclusions', 'hotels'));
    }

    // Menyimpan data wisata baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'province_id' => 'required|exists:provinces,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'inclusions' => 'array',
            'inclusions.*' => 'exists:inclusions,id',
            'hotels' => 'array',
            'hotels.*' => 'exists:hotels,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tours', 'public');
        }

        $tour = Tour::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
            'province_id' => $request->province_id,
            'image' => $imagePath,
        ]);

        if ($request->has('categories')) {
            $tour->categories()->attach($request->categories);
        }

        if ($request->has('inclusions')) {
            $tour->inclusions()->attach($request->inclusions);
        }

        if ($request->has('hotels')) {
            $tour->hotels()->attach($request->hotels);
        }

        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    // Menampilkan form edit wisata
    public function edit(Tour $tour)
    {
        $tours = Tour::with(['province', 'categories', 'inclusions', 'hotels'])->latest()->paginate(10);
        $provinces = \App\Models\Province::all();
        $categories = \App\Models\Category::all();
        $inclusions = \App\Models\Inclusion::all();
        $hotels = \App\Models\Hotel::all();
        return view('admin.tours.edit', compact('tour', 'tours', 'provinces', 'categories', 'inclusions', 'hotels'));
    }

    // Memperbarui data wisata
    public function update(Request $request, Tour $tour)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'province_id' => 'required|exists:provinces,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'inclusions' => 'array',
            'inclusions.*' => 'exists:inclusions,id',
            'hotels' => 'array',
            'hotels.*' => 'exists:hotels,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $tour->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($tour->image) {
                Storage::disk('public')->delete($tour->image);
            }
            $imagePath = $request->file('image')->store('tours', 'public');
        }

        $tour->update([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
            'province_id' => $request->province_id,
            'image' => $imagePath,
        ]);

        $tour->categories()->sync($request->categories ?? []);
        $tour->inclusions()->sync($request->inclusions ?? []);
        $tour->hotels()->sync($request->hotels ?? []);

        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata berhasil diperbarui.');
    }

    // Menghapus data wisata
    public function destroy(Tour $tour)
    {
        if ($tour->image) {
            Storage::disk('public')->delete($tour->image);
        }
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata berhasil dihapus.');
    }
}
