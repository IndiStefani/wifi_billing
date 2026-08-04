<?php

namespace App\Http\Controllers;

use App\Models\InternetPacket;
use Illuminate\Http\Request;

class InternetPacketController extends Controller
{
    public function index()
    {
        $internetPackets = InternetPacket::orderBy('nama_paket')->paginate(15);

        return view('internet-packets.index', compact('internetPackets'));
    }

    public function create()
    {
        return view('internet-packets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'bandwidth' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        InternetPacket::create($data);

        return redirect()->route('internet-packets.index')->with('success', 'Paket Internet berhasil disimpan.');
    }

    public function edit(InternetPacket $internetPacket)
    {
        return view('internet-packets.edit', compact('internetPacket'));
    }

    public function update(Request $request, InternetPacket $internetPacket)
    {
        $data = $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'bandwidth' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $internetPacket->update($data);

        return redirect()->route('internet-packets.index')->with('success', 'Paket Internet berhasil diperbarui.');
    }

    public function destroy(InternetPacket $internetPacket)
    {
        $internetPacket->delete();

        return redirect()->route('internet-packets.index')->with('success', 'Paket Internet berhasil dihapus.');
    }
}
