<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::with('branch')->orderBy('nama_area')->paginate(15);

        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        $branches = Branch::orderBy('nama')->get();

        return view('areas.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'kode_area' => ['required', 'string', 'max:50', 'unique:areas,kode_area'],
            'nama_area' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Area::create($data);

        return redirect()->route('areas.index')->with('success', 'Area berhasil disimpan.');
    }

    public function edit(Area $area)
    {
        $branches = Branch::orderBy('nama')->get();

        return view('areas.edit', compact('area', 'branches'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'kode_area' => ['required', 'string', 'max:50', 'unique:areas,kode_area,' . $area->id],
            'nama_area' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $area->update($data);

        return redirect()->route('areas.index')->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy(Area $area)
    {
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'Area berhasil dihapus.');
    }
}
