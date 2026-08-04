<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\InternetPacket;
use App\Models\Router;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerService::with(['customer.branch', 'customer.area', 'package', 'router']);

        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('customer-services.index', compact('services'));
    }

    public function create()
    {
        $customers = Customer::orderBy('nama')->get();
        $packages = InternetPacket::where('status', 'active')->orderBy('nama_paket')->get();
        $routers = Router::orderBy('nama_router')->get();

        return view('customer-services.create', compact('customers', 'packages', 'routers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cust_id' => ['required', 'exists:customers,id'],
            'pack_id' => ['required', 'exists:internet_packet,id'],
            'router_id' => ['required', 'exists:routers,id'],
            'usn' => ['required', 'string', 'max:255'],
            'pass' => ['required', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:50'],
            'mac_address' => ['nullable', 'string', 'max:50'],
            'act_date' => ['nullable', 'date'],
            'exp_date' => ['nullable', 'date', 'after_or_equal:act_date'],
            'status' => ['required', 'in:active,isolir,nonaktif'],
        ]);

        CustomerService::create($data);

        return redirect()->route('customer-services.index')->with('success', 'Layanan pelanggan berhasil disimpan.');
    }

    public function edit(CustomerService $customerService)
    {
        $customers = Customer::orderBy('nama')->get();
        $packages = InternetPacket::where('status', 'active')->orderBy('nama_paket')->get();
        $routers = Router::orderBy('nama_router')->get();

        return view('customer-services.edit', compact('customerService', 'customers', 'packages', 'routers'));
    }

    public function update(Request $request, CustomerService $customerService)
    {
        $data = $request->validate([
            'cust_id' => ['required', 'exists:customers,id'],
            'pack_id' => ['required', 'exists:internet_packet,id'],
            'router_id' => ['required', 'exists:routers,id'],
            'usn' => ['required', 'string', 'max:255'],
            'pass' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:50'],
            'mac_address' => ['nullable', 'string', 'max:50'],
            'act_date' => ['nullable', 'date'],
            'exp_date' => ['nullable', 'date', 'after_or_equal:act_date'],
            'status' => ['required', 'in:active,isolir,nonaktif'],
        ]);

        if (empty($data['pass'])) {
            unset($data['pass']);
        }

        $customerService->update($data);

        return redirect()->route('customer-services.index')->with('success', 'Layanan pelanggan berhasil diperbarui.');
    }

    public function destroy(CustomerService $customerService)
    {
        $customerService->delete();

        return redirect()->route('customer-services.index')->with('success', 'Layanan pelanggan berhasil dihapus.');
    }
}
