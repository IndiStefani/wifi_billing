<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Collector;
use App\Models\CustomerService;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BillingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $services = CustomerService::with('customer', 'package')->where('status', 'active')->get();

        if ($services->isEmpty()) {
            return;
        }

        foreach ($services as $service) {
            $month = Carbon::now()->format('Y-m');

            $invoice = Invoice::firstOrCreate(
                [
                    'cust_serv_id' => $service->id,
                    'periode' => $month,
                ],
                [
                    'inv_number' => 'INV-' . Carbon::now()->format('Ymd') . '-' . str_pad((string) ($service->id + 1000), 4, '0', STR_PAD_LEFT),
                    'nominal' => (float) ($service->package->harga ?? 0),
                    'diskon' => 0,
                    'adm_fee' => 0,
                    'total' => (float) ($service->package->harga ?? 0),
                    'due_date' => Carbon::now()->addDays(7)->toDateString(),
                    'status' => 'unpaid',
                ]
            );

            if ($service->id % 2 === 0) {
                Payment::create([
                    'inv_id' => $invoice->id,
                    'tanggal' => Carbon::now()->subDays(2)->toDateString(),
                    'metode' => 'transfer',
                    'jumlah' => (float) ($invoice->total * 0.5),
                    'reference' => 'TRX-' . $service->id,
                    'created_by' => 1,
                ]);
            }

            $collector = Collector::first();

            if ($collector) {
                Collection::firstOrCreate(
                    [
                        'inv_id' => $invoice->id,
                        'coll_id' => $collector->id,
                    ],
                    [
                        'visit_date' => Carbon::now()->subDay()->toDateString(),
                        'status' => $service->id % 2 === 0 ? 'SUCCESS' : 'NOT_HOME',
                        'note' => 'Demo penagihan otomatis',
                    ]
                );
            }
        }
    }
}
