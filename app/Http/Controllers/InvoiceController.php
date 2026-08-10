<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $this->refreshInvoiceStatuses();

        $query = Invoice::with(['customerService.customer', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $invoices = $query->latest('due_date')->latest()->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $services = CustomerService::with('customer')->orderBy('id')->get();

        return view('invoices.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cust_serv_id' => ['required', 'exists:customers_services,id'],
            'periode' => ['required', 'string', 'max:20'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'diskon' => ['required', 'numeric', 'min:0'],
            'adm_fee' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'status' => ['nullable', 'in:unpaid,partial,paid,overdue'],
            'inv_number' => ['nullable', 'string', 'max:50'],
        ]);

        $data['inv_number'] = $data['inv_number'] ?? $this->generateInvoiceNumber();
        $data['total'] = max(0, $data['nominal'] - $data['diskon'] + $data['adm_fee']);
        $data['status'] = $data['status'] ?? 'unpaid';

        Invoice::create($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil disimpan.');
    }

    public function edit(Invoice $invoice)
    {
        $services = CustomerService::with('customer')->orderBy('id')->get();

        return view('invoices.edit', compact('invoice', 'services'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'cust_serv_id' => ['required', 'exists:customers_services,id'],
            'periode' => ['required', 'string', 'max:20'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'diskon' => ['required', 'numeric', 'min:0'],
            'adm_fee' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'status' => ['nullable', 'in:unpaid,partial,paid,overdue'],
            'inv_number' => ['nullable', 'string', 'max:50'],
        ]);

        $data['total'] = max(0, $data['nominal'] - $data['diskon'] + $data['adm_fee']);

        if (empty($data['status'])) {
            $data['status'] = $invoice->status;
        }

        $invoice->update($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }

    public function generateInvoicesForActiveServices(): void
    {
        $month = Carbon::now()->format('Y-m');
        $activeServices = CustomerService::where('status', 'active')->get();

        foreach ($activeServices as $service) {
            $exists = Invoice::where('cust_serv_id', $service->id)
                ->where('periode', $month)
                ->exists();

            if ($exists) {
                continue;
            }

            $nominal = $service->package->harga ?? 0;
            $diskon = 0;
            $admFee = 0;
            $total = max(0, $nominal - $diskon + $admFee);

            Invoice::create([
                'inv_number' => $this->generateInvoiceNumber(),
                'cust_serv_id' => $service->id,
                'periode' => $month,
                'nominal' => $nominal,
                'diskon' => $diskon,
                'adm_fee' => $admFee,
                'total' => $total,
                'due_date' => Carbon::now()->addDays(7)->toDateString(),
                'status' => 'unpaid',
            ]);
        }
    }

    public function refreshInvoiceStatuses(): void
    {
        $invoices = Invoice::with('payments')->get();

        foreach ($invoices as $invoice) {
            $paidAmount = (float) $invoice->payments->sum('jumlah');
            $now = Carbon::now();

            if ($invoice->due_date && $invoice->due_date->lt($now->toDateString()) && $paidAmount < (float) $invoice->total) {
                $invoice->status = 'overdue';
            } elseif ($paidAmount >= (float) $invoice->total) {
                $invoice->status = 'paid';
                $invoice->paid_at = $now;
            } elseif ($paidAmount > 0) {
                $invoice->status = 'partial';
                $invoice->paid_at = null;
            } else {
                $invoice->status = 'unpaid';
                $invoice->paid_at = null;
            }

            $invoice->save();
        }
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ymd');
        $latest = Invoice::whereDate('created_at', today())->latest('id')->value('inv_number');

        if ($latest && str_starts_with($latest, $prefix)) {
            $sequence = (int) substr($latest, -4);

            return $prefix . '-' . str_pad($sequence + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . '-0001';
    }
}
