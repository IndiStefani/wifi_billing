<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $branches = Branch::pluck('id', 'nama')->toArray();

        $areas = [
            [
                'branch_name' => 'Cabang Jakarta',
                'kode_area' => 'JKT-01',
                'nama_area' => 'Jakarta Pusat',
                'keterangan' => 'Area utama Jakarta Pusat',
                'status' => 'active',
            ],
            [
                'branch_name' => 'Cabang Jakarta',
                'kode_area' => 'JKT-02',
                'nama_area' => 'Jakarta Selatan',
                'keterangan' => 'Area Jakarta Selatan',
                'status' => 'active',
            ],
            [
                'branch_name' => 'Cabang Bandung',
                'kode_area' => 'BDG-01',
                'nama_area' => 'Bandung Kota',
                'keterangan' => 'Area pusat Bandung',
                'status' => 'active',
            ],
        ];

        foreach ($areas as $area) {
            $branchId = $branches[$area['branch_name']] ?? null;

            if (! $branchId) {
                continue;
            }

            Area::updateOrCreate(
                ['kode_area' => $area['kode_area']],
                [
                    'branch_id' => $branchId,
                    'nama_area' => $area['nama_area'],
                    'keterangan' => $area['keterangan'],
                    'status' => $area['status'],
                ]
            );
        }
    }
}
