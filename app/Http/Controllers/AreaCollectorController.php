<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaCollector;
use App\Models\Collector;
use Illuminate\Http\Request;

class AreaCollectorController extends Controller
{
    public function index()
    {
        $areaCollectors = AreaCollector::with(['area.branch', 'collector'])->orderBy('id')->paginate(15);

        return view('area-collectors.index', compact('areaCollectors'));
    }

    public function create()
    {
        $areas = Area::with('branch')->orderBy('nama_area')->get();
        $collectors = Collector::orderBy('nama')->get();

        return view('area-collectors.create', compact('areas', 'collectors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'collector_id' => ['required', 'exists:collectors,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        AreaCollector::create($data);

        return redirect()->route('area-collectors.index')->with('success', 'Wilayah collector berhasil disimpan.');
    }

    public function edit(AreaCollector $areaCollector)
    {
        $areas = Area::with('branch')->orderBy('nama_area')->get();
        $collectors = Collector::orderBy('nama')->get();

        return view('area-collectors.edit', compact('areaCollector', 'areas', 'collectors'));
    }

    public function update(Request $request, AreaCollector $areaCollector)
    {
        $data = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'collector_id' => ['required', 'exists:collectors,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $areaCollector->update($data);

        return redirect()->route('area-collectors.index')->with('success', 'Wilayah collector berhasil diperbarui.');
    }

    public function destroy(AreaCollector $areaCollector)
    {
        $areaCollector->delete();

        return redirect()->route('area-collectors.index')->with('success', 'Wilayah collector berhasil dihapus.');
    }
}
