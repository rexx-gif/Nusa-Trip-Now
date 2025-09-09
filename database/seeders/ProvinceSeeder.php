<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['name' => 'Aceh'],
            ['name' => 'Sumatera Utara'],
            ['name' => 'Sumatera Barat'],
            ['name' => 'Riau'],
            ['name' => 'Kepulauan Riau'],
            ['name' => 'Jambi'],
            ['name' => 'Sumatera Selatan'],
            ['name' => 'Bangka Belitung'],
            ['name' => 'Bengkulu'],
            ['name' => 'Lampung'],
            ['name' => 'DKI Jakarta'],
            ['name' => 'Jawa Barat'],
            ['name' => 'Jawa Tengah'],
            ['name' => 'DI Yogyakarta'],
            ['name' => 'Jawa Timur'],
            ['name' => 'Banten'],
            ['name' => 'Bali'],
            ['name' => 'Nusa Tenggara Barat'],
            ['name' => 'Nusa Tenggara Timur'],
            ['name' => 'Kalimantan Barat'],
            ['name' => 'Kalimantan Tengah'],
            ['name' => 'Kalimantan Selatan'],
            ['name' => 'Kalimantan Timur'],
            ['name' => 'Kalimantan Utara'],
            ['name' => 'Sulawesi Utara'],
            ['name' => 'Sulawesi Tengah'],
            ['name' => 'Sulawesi Selatan'],
            ['name' => 'Sulawesi Tenggara'],
            ['name' => 'Gorontalo'],
            ['name' => 'Sulawesi Barat'],
            ['name' => 'Maluku'],
            ['name' => 'Maluku Utara'],
            ['name' => 'Papua Barat'],
            ['name' => 'Papua'],
        ];

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}
