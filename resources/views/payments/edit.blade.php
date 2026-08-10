<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Edit Pembayaran</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Invoice</label>
                            <select name="inv_id" class="form-control" required>
                                <option value="">Pilih invoice</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" {{ $payment->inv_id == $invoice->id ? 'selected' : '' }}>{{ $invoice->inv_number }} - {{ $invoice->customerService->customer->nama ?? '-' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', optional($payment->tanggal)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Metode</label>
                            <select name="metode" class="form-control" required>
                                <option value="cash" {{ $payment->metode == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="transfer" {{ $payment->metode == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="e-wallet" {{ $payment->metode == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="lainnya" {{ $payment->metode == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" class="form-control" value="{{ old('jumlah', $payment->jumlah) }}" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Reference</label>
                            <input type="text" name="reference" class="form-control" value="{{ old('reference', $payment->reference) }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
