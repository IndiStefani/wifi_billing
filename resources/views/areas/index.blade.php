<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Area</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Area</h3>
                <a href="{{ route('areas.create') }}" class="btn btn-primary">Tambah Area</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="areasTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cabang</th>
                            <th>Kode Area</th>
                            <th>Nama Area</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areas as $area)
                            <tr>
                                <td>{{ $area->id }}</td>
                                <td>{{ $area->branch->nama ?? '-' }}</td>
                                <td>{{ $area->kode_area }}</td>
                                <td>{{ $area->nama_area }}</td>
                                <td>{{ $area->keterangan }}</td>
                                <td>
                                    <span class="badge badge-{{ $area->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($area->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus area ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada area.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $areas->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#areasTable').DataTable({
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
