@extends('layouts.admin')

@section('page-title', 'Edit Paket Wisata')

@section('content')
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Edit Paket Wisata</h2>
                        <p class="text-gray-300">Perbarui informasi paket wisata "{{ $tour->name }}"</p>
                    </div>
                    <a href="{{ route('admin.tours.index') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Informasi Paket Wisata
                    </div>

                    <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Nama Wisata <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $tour->name) }}" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                    placeholder="Masukkan nama paket wisata">
                                @error('name')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Deskripsi <span class="text-red-400">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200 resize-vertical"
                                    placeholder="Jelaskan detail paket wisata ini...">{{ old('description', $tour->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Lokasi <span class="text-red-400">*</span>
                                </label>
                                <input type="text" name="location" id="location" value="{{ old('location', $tour->location) }}" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                    placeholder="Masukkan lokasi wisata">
                                @error('location')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Harga per Orang <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price', $tour->price) }}" required min="0" step="1000"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200"
                                        placeholder="0">
                                </div>
                                @error('price')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="province_id" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Provinsi <span class="text-red-400">*</span>
                                </label>
                                <select name="province_id" id="province_id" required
                                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                                    <option value="" class="bg-gray-700">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id', $tour->province_id) == $province->id ? 'selected' : '' }} class="bg-gray-700">
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-white mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Gambar Wisata
                                </label>
                                <div class="relative">
                                    <input type="file" name="image" id="image" accept="image/*"
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-yellow-500 file:text-black hover:file:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200">
                                    <div class="mt-2 text-sm text-gray-400">
                                        Format: JPG, PNG, GIF. Maksimal 5MB. Biarkan kosong jika tidak ingin mengubah gambar.
                                    </div>
                                </div>
                                @if($tour->image)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-400 mb-2">Gambar saat ini:</p>
                                        <img src="{{ asset('storage/' . $tour->image) }}" alt="{{ $tour->name }}" class="h-32 w-auto rounded-lg border border-gray-600">
                                    </div>
                                @endif
                                @error('image')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Kategori Wisata
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($categories as $category)
                                    <label class="flex items-center p-3 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 cursor-pointer transition duration-200">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            {{ is_array(old('categories', $tour->categories->pluck('id')->toArray())) && in_array($category->id, old('categories', $tour->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="w-4 h-4 text-yellow-500 bg-gray-700 border-gray-600 rounded focus:ring-yellow-500 focus:ring-2">
                                        <span class="ml-3 text-white text-sm">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <p class="text-red-400 text-sm mt-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Hotels -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z" />
                                </svg>
                                Pilih Hotel
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($hotels as $hotel)
                                    <label class="flex items-center p-3 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 cursor-pointer transition duration-200">
                                        <input type="checkbox" name="hotels[]" value="{{ $hotel->id }}"
                                            {{ is_array(old('hotels', $tour->hotels->pluck('id')->toArray())) && in_array($hotel->id, old('hotels', $tour->hotels->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="w-4 h-4 text-yellow-500 bg-gray-700 border-gray-600 rounded focus:ring-yellow-500 focus:ring-2">
                                        <span class="ml-3 text-white text-sm">{{ $hotel->name }} - Rp {{ number_format($hotel->price, 0, ',', '.') }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('hotels')
                                <p class="text-red-400 text-sm mt-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Inclusions -->
                        <div>
                            <label class="block text-sm font-medium text-white mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Fasilitas / Inklusi
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($inclusions as $inclusion)
                                    <label class="flex items-center p-3 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 cursor-pointer transition duration-200">
                                        <input type="checkbox" name="inclusions[]" value="{{ $inclusion->id }}"
                                            {{ is_array(old('inclusions', $tour->inclusions->pluck('id')->toArray())) && in_array($inclusion->id, old('inclusions', $tour->inclusions->pluck('id')->toArray())) ? 'checked' : '' }}
                                            class="w-4 h-4 text-yellow-500 bg-gray-700 border-gray-600 rounded focus:ring-yellow-500 focus:ring-2">
                                        <span class="ml-3 text-white text-sm">{{ $inclusion->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('inclusions')
                                <p class="text-red-400 text-sm mt-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-600">
                            <a href="{{ route('admin.tours.index') }}" class="btn btn-sm" style="background: var(--secondary-black); color: white;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳 极速赛车开奖直播 历史记录 澳洲幸运10开奖结果体彩 飞艇计划全天免费软件网页版 幸运飞行艇官方开奖记录 168飞艇官网开奖结果 澳洲幸运10是官方开奖吗 查看澳洲幸运10开奖结果 幸运飞行艇历史开奖记录 澳洲幸运10开奖官网 168飞艇官网开奖结果 飞艇在线计划稳 全天免费计划人工网页版 澳洲10开奖结果 飞艇在线计划稳 4L19 7" />
                                </svg>
                                Perbarui Paket Wisata
                            </button>
                        </div>
                    </form>
                </div>
@endsection
