<?php

namespace Database\Seeders;

use App\Models\InternetPacket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InternetPacketSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $packets = [
            [
                'nama_paket' => 'Bronet 10 Mbps',
                'bandwidth' => '10 Mbps',
                'harga' => 150000,
                'deskripsi' => 'Cocok untuk penggunaan rumahan dan browsing ringan.',
                'status' => 'active',
            ],
            [
                'nama_paket' => 'Bronet 20 Mbps',
                'bandwidth' => '20 Mbps',
                'harga' => 220000,
                'deskripsi' => 'Pilihan pas untuk streaming dan kerja remote.',
                'status' => 'active',
            ],
            [
                'nama_paket' => 'Bronet 50 Mbps',
                'bandwidth' => '50 Mbps',
                'harga' => 350000,
                'deskripsi' => 'Akses cepat untuk keluarga dengan banyak perangkat.',
                'status' => 'active',
            ],
            [
                'nama_paket' => 'Bronet 100 Mbps',
                'bandwidth' => '100 Mbps',
                'harga' => 550000,
                'deskripsi' => 'Paket premium untuk streaming HD dan gaming.',
                'status' => 'active',
            ],
            [
                'nama_paket' => 'Bronet Nonaktif',
                'bandwidth' => '5 Mbps',
                'harga' => 90000,
                'deskripsi' => 'Paket promosi yang sementara tidak aktif.',
                'status' => 'inactive',
            ],
        ];

        foreach ($packets as $packet) {
            InternetPacket::updateOrCreate(
                ['nama_paket' => $packet['nama_paket']],
                $packet
            );
        }
    }
}
