<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Wilayah Collector</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Wilayah Collector</h3>
                <a href="{{ route('area-collectors.create') }}" class="btn btn-primary">Tambah Wilayah</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="areaCollectorsTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cabang</th>
                            <th>Area</th>
                            <th>Collector</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areaCollectors as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->area->branch->nama ?? '-' }}</td>
                                <td>{{ $item->area->nama_area ?? '-' }}</td>
                                <td>{{ $item->collector->nama ?? '-' }}</td>
                                <td>{{ optional($item->start_date)->format('d M Y') ?? '-' }}</td>
                                <td>{{ optional($item->end_date)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('area-collectors.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('area-collectors.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus wilayah collector ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data wilayah collector.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $areaCollectors->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#areaCollectorsTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    ordering: true,
                    searching: true,
                    paging: true,
                });
            });
        </script>
    @endpush
</x-app-layout>
