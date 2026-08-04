<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Penagih</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Penagih</h3>
                <a href="{{ route('collectors.create') }}" class="btn btn-primary">Tambah Penagih</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="collectorsTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collectors as $collector)
                            <tr>
                                <td>{{ $collector->id }}</td>
                                <td>{{ $collector->nama }}</td>
                                <td>{{ $collector->alamat }}</td>
                                <td>{{ $collector->telepon }}</td>
                                <td>
                                    <span class="badge badge-{{ $collector->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($collector->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('collectors.edit', $collector) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('collectors.destroy', $collector) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus penagih ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada penagih.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $collectors->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#collectorsTable').DataTable({
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
