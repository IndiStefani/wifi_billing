<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $branches = [
            [
                'nama' => 'Cabang Jakarta',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta',
                'telepon' => '021-1234567',
                'status' => 'active',
            ],
            [
                'nama' => 'Cabang Bandung',
                'alamat' => 'Jl. Asia Afrika No. 22, Bandung',
                'telepon' => '022-7654321',
                'status' => 'active',
            ],
            [
                'nama' => 'Cabang Surabaya',
                'alamat' => 'Jl. Tunjungan No. 15, Surabaya',
                'telepon' => '031-9876543',
                'status' => 'inactive',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['nama' => $branch['nama']],
                $branch
            );
        }
    }
}
