<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $invoiceController = app(InvoiceController::class);
        $invoiceController->generateInvoicesForActiveServices();
        $invoiceController->refreshInvoiceStatuses();

        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $totalCustomers = Customer::count();
        $activeServices = CustomerService::where('status', 'active')->count();
        $isolirServices = CustomerService::where('status', 'isolir')->count();

        $invoicesThisMonth = Invoice::whereBetween('created_at', [$monthStart, $monthEnd])->get();
        $invoiceUnpaid = $invoicesThisMonth->where('status', 'unpaid')->count();
        $invoicePaid = $invoicesThisMonth->where('status', 'paid')->count();

        $totalTagihanBulanIni = $invoicesThisMonth->sum('total');
        $totalTerbayarBulanIni = Payment::whereBetween('tanggal', [$monthStart->toDateString(), $monthEnd->toDateString()])->sum('jumlah');

        $upcomingDueInvoices = Invoice::with('customerService.customer')
            ->where('status', '!=', 'paid')
            ->whereNotNull('due_date')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $recentCollections = Collection::with(['invoice.customerService.customer', 'collector'])
            ->latest('visit_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalCustomers',
            'activeServices',
            'isolirServices',
            'invoiceUnpaid',
            'invoicePaid',
            'totalTagihanBulanIni',
            'totalTerbayarBulanIni',
            'upcomingDueInvoices',
            'recentCollections'
        ));
    }
}
