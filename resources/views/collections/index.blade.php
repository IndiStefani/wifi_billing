<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Penagihan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Aktivitas Penagihan</h3>
                <a href="{{ route('collections.create') }}" class="btn btn-primary">Tambah Catatan</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No. Invoice</th>
                            <th>Pelanggan</th>
                            <th>Collector</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collections as $collection)
                            <tr>
                                <td>{{ $collection->invoice->inv_number ?? '-' }}</td>
                                <td>{{ $collection->invoice->customerService->customer->nama ?? '-' }}</td>
                                <td>{{ $collection->collector->nama ?? '-' }}</td>
                                <td>{{ optional($collection->visit_date)->format('d M Y') }}</td>
                                <td>{{ $collection->status }}</td>
                                <td>{{ Str::limit($collection->note ?? '-', 40) }}</td>
                                <td>
                                    <a href="{{ route('collections.edit', $collection) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('collections.destroy', $collection) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus catatan penagihan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada penagihan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $collections->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
