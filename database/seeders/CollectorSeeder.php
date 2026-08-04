<?php

namespace Database\Seeders;

use App\Models\Collector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $collectors = [
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Melati No. 7, Jakarta',
                'telepon' => '0812-3456-7890',
                'status' => 'active',
            ],
            [
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. Braga No. 14, Bandung',
                'telepon' => '0813-9876-5432',
                'status' => 'active',
            ],
            [
                'nama' => 'Anton Wijaya',
                'alamat' => 'Jl. Raya Darmo No. 8, Surabaya',
                'telepon' => '0814-1122-3344',
                'status' => 'inactive',
            ],
        ];

        foreach ($collectors as $collector) {
            Collector::updateOrCreate(
                ['nama' => $collector['nama']],
                $collector
            );
        }
    }
}
