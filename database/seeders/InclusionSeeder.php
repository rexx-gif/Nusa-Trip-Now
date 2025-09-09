<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inclusion;

class InclusionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inclusions = [
            ['name' => 'Transportasi'],
            ['name' => 'Akomodasi'],
            ['name' => 'Makanan'],
            ['name' => 'Guide'],
            ['name' => 'Tiket Masuk'],
            ['name' => 'Asuransi'],
            // Add more inclusions as needed
        ];

        foreach ($inclusions as $inclusion) {
            Inclusion::create($inclusion);
        }
    }
}
