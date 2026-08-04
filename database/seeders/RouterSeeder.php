<?php

namespace Database\Seeders;

use App\Models\Router;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouterSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $branches = Branch::pluck('id', 'nama')->toArray();

        $routers = [
            [
                'branch_name' => 'Cabang Jakarta',
                'nama_router' => 'Router Jakarta 1',
                'ip_address' => '192.168.10.1',
                'api_port' => 8728,
                'username' => 'admin',
                'password' => 'password123',
                'lokasi' => 'Jakarta',
                'status' => 'active',
            ],
            [
                'branch_name' => 'Cabang Bandung',
                'nama_router' => 'Router Bandung 1',
                'ip_address' => '192.168.20.1',
                'api_port' => 8728,
                'username' => 'admin',
                'password' => 'password123',
                'lokasi' => 'Bandung',
                'status' => 'active',
            ],
            [
                'branch_name' => 'Cabang Surabaya',
                'nama_router' => 'Router Surabaya 1',
                'ip_address' => '192.168.30.1',
                'api_port' => 8728,
                'username' => 'admin',
                'password' => 'password123',
                'lokasi' => 'Surabaya',
                'status' => 'inactive',
            ],
        ];

        foreach ($routers as $router) {
            $branchId = $branches[$router['branch_name']] ?? null;

            if (! $branchId) {
                continue;
            }

            Router::updateOrCreate(
                ['nama_router' => $router['nama_router']],
                [
                    'branch_id' => $branchId,
                    'ip_address' => $router['ip_address'],
                    'api_port' => $router['api_port'],
                    'username' => $router['username'],
                    'password' => $router['password'],
                    'lokasi' => $router['lokasi'],
                    'status' => $router['status'],
                ]
            );
        }
    }
}
