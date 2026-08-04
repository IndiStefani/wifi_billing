<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use Illuminate\Http\Request;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = Collector::orderBy('nama')->paginate(15);

        return view('collectors.index', compact('collectors'));
    }

    public function create()
    {
        return view('collectors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Collector::create($data);

        return redirect()->route('collectors.index')->with('success', 'Collector berhasil disimpan.');
    }

    public function edit(Collector $collector)
    {
        return view('collectors.edit', compact('collector'));
    }

    public function update(Request $request, Collector $collector)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $collector->update($data);

        return redirect()->route('collectors.index')->with('success', 'Collector berhasil diperbarui.');
    }

    public function destroy(Collector $collector)
    {
        $collector->delete();

        return redirect()->route('collectors.index')->with('success', 'Collector berhasil dihapus.');
    }
}
