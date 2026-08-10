<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice.customerService.customer', 'creator'])
            ->latest()
            ->paginate(15);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::with('customerService.customer')->orderBy('created_at', 'desc')->get();

        return view('payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inv_id' => ['required', 'exists:invoices,id'],
            'tanggal' => ['required', 'date'],
            'metode' => ['required', 'in:cash,transfer,e-wallet,lainnya'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $data['created_by'] = auth()->id();
        $payment = Payment::create($data);

        $invoice = $payment->invoice;
        $this->syncInvoiceStatus($invoice);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil disimpan.');
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::with('customerService.customer')->orderBy('created_at', 'desc')->get();

        return view('payments.edit', compact('payment', 'invoices'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'inv_id' => ['required', 'exists:invoices,id'],
            'tanggal' => ['required', 'date'],
            'metode' => ['required', 'in:cash,transfer,e-wallet,lainnya'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $payment->update($data);
        $this->syncInvoiceStatus($payment->invoice);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;
        $payment->delete();
        $this->syncInvoiceStatus($invoice);

        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dihapus.');
    }

    private function syncInvoiceStatus(Invoice $invoice): void
    {
        $paidAmount = (float) $invoice->payments()->sum('jumlah');
        $now = now();

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
