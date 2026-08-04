<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Paket Internet</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Paket Internet</h3>
                <a href="{{ route('internet-packets.create') }}" class="btn btn-primary">Tambah Paket</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="internetPacketsTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Paket</th>
                            <th>Bandwidth</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($internetPackets as $packet)
                            <tr>
                                <td>{{ $packet->id }}</td>
                                <td>{{ $packet->nama_paket }}</td>
                                <td>{{ $packet->bandwidth }}</td>
                                <td>Rp {{ number_format($packet->harga, 2, ',', '.') }}</td>
                                <td>{{ $packet->deskripsi }}</td>
                                <td>
                                    <span class="badge badge-{{ $packet->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($packet->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('internet-packets.edit', $packet) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('internet-packets.destroy', $packet) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus paket internet ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada paket internet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $internetPackets->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#internetPacketsTable').DataTable({
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
