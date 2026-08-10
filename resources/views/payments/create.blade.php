<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Tambah Pembayaran</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Invoice</label>
                            <select name="inv_id" class="form-control" required>
                                <option value="">Pilih invoice</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}">{{ $invoice->inv_number }} - {{ $invoice->customerService->customer->nama ?? '-' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Metode</label>
                            <select name="metode" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="e-wallet">E-Wallet</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Reference</label>
                            <input type="text" name="reference" class="form-control" placeholder="No. transaksi / referensi">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
