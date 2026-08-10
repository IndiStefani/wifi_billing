<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Pembayaran</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Pembayaran</h3>
                <a href="{{ route('payments.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
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
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Reference</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->invoice->inv_number ?? '-' }}</td>
                                <td>{{ $payment->invoice->customerService->customer->nama ?? '-' }}</td>
                                <td>{{ optional($payment->tanggal)->format('d M Y') }}</td>
                                <td>{{ ucfirst($payment->metode) }}</td>
                                <td>Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $payment->reference ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus pembayaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
