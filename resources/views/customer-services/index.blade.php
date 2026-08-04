<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Layanan Pelanggan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Layanan Pelanggan</h3>
                <a href="{{ route('customer-services.create') }}" class="btn btn-primary">Tambah Layanan</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="customerServicesTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Cabang</th>
                            <th>Area</th>
                            <th>Paket</th>
                            <th>Router</th>
                            <th>Registrasi</th>
                            <th>Expire</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>{{ $service->customer->nama ?? '-' }}</td>
                                <td>{{ $service->customer->branch->nama ?? '-' }}</td>
                                <td>{{ $service->customer->area->nama_area ?? '-' }}</td>
                                <td>{{ $service->package->nama_paket ?? '-' }}</td>
                                <td>{{ $service->router->nama_router ?? '-' }}</td>
                                <td>{{ optional($service->act_date)->format('d M Y') ?? '-' }}</td>
                                <td>{{ optional($service->exp_date)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $service->status === 'active' ? 'success' : ($service->status === 'isolir' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('customer-services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('customer-services.destroy', $service) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus layanan pelanggan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada layanan pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#customerServicesTable').DataTable({
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
