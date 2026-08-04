<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\AreaCollector;
use App\Models\Collector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaCollectorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $areas = Area::pluck('id', 'kode_area')->flip()->toArray();
        $collectors = Collector::pluck('id', 'nama')->flip()->toArray();

        $mappings = [
            [
                'area_code' => 'JKT-01',
                'collector_name' => 'Budi Santoso',
                'start_date' => '2026-01-01',
                'end_date' => null,
                'status' => 'active',
            ],
            [
                'area_code' => 'JKT-02',
                'collector_name' => 'Siti Aminah',
                'start_date' => '2026-02-15',
                'end_date' => null,
                'status' => 'active',
            ],
            [
                'area_code' => 'BDG-01',
                'collector_name' => 'Anton Wijaya',
                'start_date' => '2026-03-01',
                'end_date' => '2026-06-30',
                'status' => 'inactive',
            ],
        ];

        foreach ($mappings as $mapping) {
            $areaId = $areas[$mapping['area_code']] ?? null;
            $collectorId = $collectors[$mapping['collector_name']] ?? null;

            if (! $areaId || ! $collectorId) {
                continue;
            }

            AreaCollector::updateOrCreate(
                [
                    'area_id' => $areaId,
                    'collector_id' => $collectorId,
                ],
                [
                    'start_date' => $mapping['start_date'],
                    'end_date' => $mapping['end_date'],
                    'status' => $mapping['status'],
                ]
            );
        }
    }
}
