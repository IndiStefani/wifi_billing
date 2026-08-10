<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Pelanggan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title">Daftar Pelanggan</h3>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('customers.export') }}" class="btn btn-outline-success">Export CSV</a>
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#importModal">Import File</button>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table id="customersTable" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Cabang</th>
                            <th>Area</th>
                            <th>Registrasi</th>
                            <th>Status</th>
                            <th>Paket Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td><a href="{{ route('customers.show', $customer) }}">{{ $customer->cust_code }}</a></td>
                                <td>{{ $customer->nama }}</td>
                                <td>{{ $customer->branch->nama ?? '-' }}</td>
                                <td>{{ $customer->area->nama_area ?? '-' }}</td>
                                <td>{{ optional($customer->register_date)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td>{{ $customer->latestService->package->nama_paket ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus pelanggan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Pelanggan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File CSV/XLS/XLSX</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <small class="text-muted">Format kolom: cust_code, branch_name, area_name, nama, email, telepon, alamat, register_date, status</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#customersTable').DataTable({
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
