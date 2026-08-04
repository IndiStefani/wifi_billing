<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Detail Pelanggan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title">{{ $customer->cust_code }} - {{ $customer->nama }}</h3>
                    <p class="mb-0 text-muted">{{ $customer->branch->nama ?? 'Cabang tidak tersedia' }} / {{ $customer->area->nama_area ?? 'Area tidak tersedia' }}</p>
                </div>
                <div>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <strong>Kode Pelanggan</strong>
                            <div>{{ $customer->cust_code }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Nama</strong>
                            <div>{{ $customer->nama }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Email</strong>
                            <div>{{ $customer->email ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Telepon</strong>
                            <div>{{ $customer->telepon ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <strong>Cabang</strong>
                            <div>{{ $customer->branch->nama ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Area</strong>
                            <div>{{ $customer->area->nama_area ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Alamat</strong>
                            <div>{{ $customer->alamat ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Registrasi</strong>
                            <div>{{ optional($customer->register_date)->format('d M Y') ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <strong>Status</strong>
                            <div>
                                <span class="badge badge-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Service Terbaru</strong>
                            <div>{{ $customer->latestService->package->nama_paket ?? 'Belum ada paket' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Router</strong>
                            <div>{{ $customer->latestService->router->nama_router ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Service</strong>
                            <div>{{ optional($customer->latestService->created_at)->format('d M Y H:i') ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                @if($customer->services->isNotEmpty())
                    <hr>
                    <h5>Riwayat Paket</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Paket</th>
                                    <th>Router</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->services as $index => $service)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $service->package->nama_paket ?? '-' }}</td>
                                        <td>{{ $service->router->nama_router ?? '-' }}</td>
                                        <td>{{ optional($service->created_at)->format('d M Y H:i') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
