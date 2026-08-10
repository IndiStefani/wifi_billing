<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Invoice</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Invoice</h3>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">Tambah Invoice</a>
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
                            <th>Periode</th>
                            <th>Nominal</th>
                            <th>Total</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->inv_number }}</td>
                                <td>{{ $invoice->customerService->customer->nama ?? '-' }}</td>
                                <td>{{ $invoice->periode }}</td>
                                <td>Rp {{ number_format($invoice->nominal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                                <td>{{ optional($invoice->due_date)->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $invoice->status === 'paid' ? 'success' : ($invoice->status === 'partial' ? 'warning' : ($invoice->status === 'overdue' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus invoice ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada invoice.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
