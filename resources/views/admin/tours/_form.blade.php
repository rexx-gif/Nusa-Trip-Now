<div class="space-y-6">
    <!-- Nama Paket Wisata -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Paket Wisata</label>
        <input type="text" name="name" id="name" value="{{ old('name', $tour->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Deskripsi -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ old('description', $tour->description ?? '') }}</textarea>
        @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Lokasi -->
    <div>
        <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
        <input type="text" name="location" id="location" value="{{ old('location', $tour->location ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('location') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Harga -->
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
        <input type="number" name="price" id="price" value="{{ old('price', $tour->price ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>

    <!-- Gambar Utama -->
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Gambar Utama</label>
        <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        @if(isset($tour) && $tour->image)
            <img src="{{ asset('storage/' . $tour->image) }}" alt="Current image" class="mt-4 h-32 w-auto rounded-md shadow-sm">
            <p class="text-xs text-gray-500 mt-1">Gambar saat ini. Upload file baru akan menggantinya.</p>
        @endif
        @error('image') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
    </div>
</div>

<!-- Tombol Aksi -->
<div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
    <a href="{{ route('admin.tours.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
        Batal
    </a>
    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        {{ isset($tour) ? 'Perbarui' : 'Simpan' }}
    </button>
</div>