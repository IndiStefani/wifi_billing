<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\Collection;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::with(['invoice.customerService.customer', 'collector'])
            ->latest('visit_date')
            ->latest()
            ->paginate(15);

        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $invoices = Invoice::with('customerService.customer')->orderBy('created_at', 'desc')->get();
        $collectors = Collector::orderBy('nama')->get();

        return view('collections.create', compact('invoices', 'collectors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'inv_id' => ['required', 'exists:invoices,id'],
            'coll_id' => ['required', 'exists:collectors,id'],
            'visit_date' => ['required', 'date'],
            'status' => ['required', 'in:SUCCESS,NOT_HOME,PROMISE_TO_PAY,REJECTED'],
            'note' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'foto' => ['nullable', 'string', 'max:255'],
        ]);

        Collection::create($data);

        return redirect()->route('collections.index')->with('success', 'Catatan penagihan berhasil disimpan.');
    }

    public function edit(Collection $collection)
    {
        $invoices = Invoice::with('customerService.customer')->orderBy('created_at', 'desc')->get();
        $collectors = Collector::orderBy('nama')->get();

        return view('collections.edit', compact('collection', 'invoices', 'collectors'));
    }

    public function update(Request $request, Collection $collection)
    {
        $data = $request->validate([
            'inv_id' => ['required', 'exists:invoices,id'],
            'coll_id' => ['required', 'exists:collectors,id'],
            'visit_date' => ['required', 'date'],
            'status' => ['required', 'in:SUCCESS,NOT_HOME,PROMISE_TO_PAY,REJECTED'],
            'note' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'foto' => ['nullable', 'string', 'max:255'],
        ]);

        $collection->update($data);

        return redirect()->route('collections.index')->with('success', 'Catatan penagihan berhasil diperbarui.');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()->route('collections.index')->with('success', 'Catatan penagihan berhasil dihapus.');
    }
}
