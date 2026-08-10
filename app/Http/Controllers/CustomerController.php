<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function export()
    {
        $customers = Customer::with(['branch', 'area'])->orderBy('nama')->get();

        $filename = 'customers-' . now()->format('YmdHis') . '.csv';
        $tempPath = storage_path('app/public/exports/' . $filename);

        if (! is_dir(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $handle = fopen($tempPath, 'w');
        fputcsv($handle, ['cust_code', 'branch_name', 'area_name', 'nama', 'email', 'telepon', 'alamat', 'register_date', 'status']);

        foreach ($customers as $customer) {
            fputcsv($handle, [
                $customer->cust_code,
                $customer->branch->nama ?? '',
                $customer->area->nama_area ?? '',
                $customer->nama,
                $customer->email,
                $customer->telepon,
                $customer->alamat,
                optional($customer->register_date)->format('Y-m-d'),
                $customer->status,
            ]);
        }

        fclose($handle);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls'],
        ]);

        $path = $request->file('file')->store('imports', 'local');
        $fullPath = storage_path('app/' . $path);

        if (! file_exists($fullPath)) {
            return back()->with('error', 'File import tidak ditemukan.');
        }

        $rows = [];
        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if ($extension === 'csv') {
            $handle = fopen($fullPath, 'r');
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 2) {
                    continue;
                }
                $rows[] = array_combine($header, $row);
            }
            fclose($handle);
        } else {
            $spreadsheet = IOFactory::load($fullPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            $header = array_shift($rows);
            $rows = array_map(function ($row) use ($header) {
                return array_combine($header, $row);
            }, $rows);
        }

        $imported = 0;

        foreach ($rows as $row) {
            if (! $row || ! is_array($row)) {
                continue;
            }

            $branch = Branch::where('nama', trim($row['branch_name'] ?? ''))->first();
            $area = Area::where('nama_area', trim($row['area_name'] ?? ''))->first();

            $customerData = [
                'cust_code' => trim($row['cust_code'] ?? ''),
                'branch_id' => $branch?->id,
                'area_id' => $area?->id,
                'nama' => trim($row['nama'] ?? ''),
                'email' => trim($row['email'] ?? ''),
                'telepon' => trim($row['telepon'] ?? ''),
                'alamat' => trim($row['alamat'] ?? ''),
                'register_date' => ! empty($row['register_date']) ? $row['register_date'] : null,
                'status' => ! empty($row['status']) ? $row['status'] : 'active',
            ];

            if (empty($customerData['cust_code']) || empty($customerData['nama'])) {
                continue;
            }

            Customer::updateOrCreate(
                ['cust_code' => $customerData['cust_code']],
                $customerData
            );

            $imported++;
        }

        Storage::disk('local')->delete($path);

        return back()->with('success', 'Import pelanggan selesai. ' . $imported . ' data diproses.');
    }
}
