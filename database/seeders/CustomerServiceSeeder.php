<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Collector;
use App\Models\InternetPacket;
use App\Models\Router;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerServiceSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $customers = Customer::pluck('id', 'cust_code')->toArray();
        $packets = InternetPacket::where('status', 'active')->pluck('id', 'nama_paket')->toArray();
        $routers = Router::pluck('id', 'nama_router')->toArray();

        $services = [
            [
                'cust_code' => 'CUST-001',
                'packet_name' => 'Bronet 10 Mbps',
                'router_name' => 'Router Jakarta 1',
                'usn' => 'andi.10',
                'pass' => 'pass1234',
                'ip_address' => '10.10.10.10',
                'mac_address' => '00:11:22:33:44:55',
                'act_date' => '2026-01-15',
                'exp_date' => '2027-01-15',
                'status' => 'active',
            ],
            [
                'cust_code' => 'CUST-002',
                'packet_name' => 'Bronet 20 Mbps',
                'router_name' => 'Router Bandung 1',
                'usn' => 'dina.20',
                'pass' => 'pass1234',
                'ip_address' => '10.20.20.20',
                'mac_address' => '00:11:22:33:44:66',
                'act_date' => '2026-02-10',
                'exp_date' => '2027-02-10',
                'status' => 'isolir',
            ],
            [
                'cust_code' => 'CUST-003',
                'packet_name' => 'Bronet 50 Mbps',
                'router_name' => 'Router Jakarta 1',
                'usn' => 'bambang.50',
                'pass' => 'pass1234',
                'ip_address' => '10.10.30.30',
                'mac_address' => '00:11:22:33:44:77',
                'act_date' => '2026-03-20',
                'exp_date' => '2027-03-20',
                'status' => 'nonaktif',
            ],
        ];

        foreach ($services as $service) {
            $customerId = $customers[$service['cust_code']] ?? null;
            $packetId = $packets[$service['packet_name']] ?? null;
            $routerId = $routers[$service['router_name']] ?? null;

            if (! $customerId || ! $packetId || ! $routerId) {
                continue;
            }

            CustomerService::updateOrCreate(
                [
                    'cust_id' => $customerId,
                    'pack_id' => $packetId,
                    'router_id' => $routerId,
                ],
                [
                    'usn' => $service['usn'],
                    'pass' => $service['pass'],
                    'ip_address' => $service['ip_address'],
                    'mac_address' => $service['mac_address'],
                    'act_date' => $service['act_date'],
                    'exp_date' => $service['exp_date'],
                    'status' => $service['status'],
                ]
            );
        }
    }
}
