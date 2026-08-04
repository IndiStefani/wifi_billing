<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['branch', 'area', 'latestService.package'])
            ->orderBy('nama')
            ->paginate(15);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $branches = Branch::orderBy('nama')->get();
        $areas = Area::with('branch')->orderBy('nama_area')->get();

        return view('customers.create', compact('branches', 'areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cust_code' => ['required', 'string', 'max:50', 'unique:customers,cust_code'],
            'branch_id' => ['required', 'exists:branches,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'register_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil disimpan.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['branch', 'area', 'services.package', 'services.router']);

        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::orderBy('nama')->get();
        $areas = Area::with('branch')->orderBy('nama_area')->get();
        $customer->load(['services.package', 'services.router']);

        return view('customers.edit', compact('customer', 'branches', 'areas'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'cust_code' => ['required', 'string', 'max:50', 'unique:customers,cust_code,' . $customer->id],
            'branch_id' => ['required', 'exists:branches,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'register_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
