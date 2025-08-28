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
        $tours = Tour::latest()->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    // Menampilkan form tambah wisata
    public function create()
    {
        return view('admin.tours.create');
    }

    // Menyimpan data wisata baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tours', 'public');
        }

        Tour::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.tours.index')->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    // Menampilkan form edit wisata
    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    // Memperbarui data wisata
    public function update(Request $request, Tour $tour)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
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
            'image' => $imagePath,
        ]);

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
