<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Province;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Grand Hotel Bali',
                'province_id' => Province::where('name', 'Bali')->first()->id ?? 1,
                'city' => 'Denpasar',
                'price' => 750000,
                'description' => 'Hotel mewah dengan pemandangan pantai yang indah dan fasilitas lengkap untuk kenyamanan Anda.'
            ],
            [
                'name' => 'Mountain View Resort',
                'province_id' => Province::where('name', 'Jawa Barat')->first()->id ?? 2,
                'city' => 'Bandung',
                'price' => 450000,
                'description' => 'Resort dengan pemandangan pegunungan yang menakjubkan, cocok untuk wisatawan yang mencari ketenangan.'
            ],
            [
                'name' => 'Jakarta City Hotel',
                'province_id' => Province::where('name', 'DKI Jakarta')->first()->id ?? 3,
                'city' => 'Jakarta Pusat',
                'price' => 550000,
                'description' => 'Hotel modern di pusat kota dengan akses mudah ke berbagai atraksi wisata dan pusat perbelanjaan.'
            ],
            [
                'name' => 'Borobudur Heritage Hotel',
                'province_id' => Province::where('name', 'Jawa Tengah')->first()->id ?? 4,
                'city' => 'Magelang',
                'price' => 380000,
                'description' => 'Hotel heritage dengan arsitektur tradisional Jawa yang elegan, dekat dengan Candi Borobudur.'
            ],
            [
                'name' => 'Lombok Beach Resort',
                'province_id' => Province::where('name', 'Nusa Tenggara Barat')->first()->id ?? 5,
                'city' => 'Mataram',
                'price' => 420000,
                'description' => 'Resort tepi pantai dengan pasir putih dan air laut yang jernih, sempurna untuk liburan keluarga.'
            ],
            [
                'name' => 'Yogyakarta Palace Hotel',
                'province_id' => Province::where('name', 'DI Yogyakarta')->first()->id ?? 6,
                'city' => 'Yogyakarta',
                'price' => 480000,
                'description' => 'Hotel dengan nuansa kerajaan yang mewah, lokasi strategis dekat dengan Keraton Yogyakarta.'
            ]
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
