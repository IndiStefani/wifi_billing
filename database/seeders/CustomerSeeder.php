<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Branch;
use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $branches = Branch::pluck('id', 'nama')->toArray();
        $areas = Area::pluck('id', 'kode_area')->toArray();

        $customers = [
            [
                'cust_code' => 'CUST-001',
                'branch_name' => 'Cabang Jakarta',
                'area_code' => 'JKT-01',
                'nama' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Thamrin No. 10, Jakarta',
                'register_date' => '2026-01-10',
                'status' => 'active',
            ],
            [
                'cust_code' => 'CUST-002',
                'branch_name' => 'Cabang Bandung',
                'area_code' => 'BDG-01',
                'nama' => 'Dina Sari',
                'email' => 'dina@example.com',
                'telepon' => '081398765432',
                'alamat' => 'Jl. Dago No. 20, Bandung',
                'register_date' => '2026-02-05',
                'status' => 'active',
            ],
            [
                'cust_code' => 'CUST-003',
                'branch_name' => 'Cabang Jakarta',
                'area_code' => 'JKT-02',
                'nama' => 'Bambang Suharto',
                'email' => 'bambang@example.com',
                'telepon' => '081211223344',
                'alamat' => 'Jl. Kebayoran No. 5, Jakarta',
                'register_date' => '2026-03-15',
                'status' => 'inactive',
            ],
        ];

        foreach ($customers as $customer) {
            $branchId = $branches[$customer['branch_name']] ?? null;
            $areaId = $areas[$customer['area_code']] ?? null;

            if (! $branchId || ! $areaId) {
                continue;
            }

            Customer::updateOrCreate(
                ['cust_code' => $customer['cust_code']],
                [
                    'branch_id' => $branchId,
                    'area_id' => $areaId,
                    'nama' => $customer['nama'],
                    'email' => $customer['email'],
                    'telepon' => $customer['telepon'],
                    'alamat' => $customer['alamat'],
                    'register_date' => $customer['register_date'],
                    'status' => $customer['status'],
                ]
            );
        }
    }
}
