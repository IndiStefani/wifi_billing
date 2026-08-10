<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Edit Invoice</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Layanan Pelanggan</label>
                            <select name="cust_serv_id" class="form-control" required>
                                <option value="">Pilih layanan</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ $invoice->cust_serv_id == $service->id ? 'selected' : '' }}>{{ $service->customer->nama ?? '-' }} - {{ $service->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>No. Invoice</label>
                            <input type="text" name="inv_number" class="form-control" value="{{ old('inv_number', $invoice->inv_number) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Periode</label>
                            <input type="text" name="periode" class="form-control" value="{{ old('periode', $invoice->periode) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Jatuh Tempo</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Nominal</label>
                            <input type="number" step="0.01" name="nominal" class="form-control" value="{{ old('nominal', $invoice->nominal) }}" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Diskon</label>
                            <input type="number" step="0.01" name="diskon" class="form-control" value="{{ old('diskon', $invoice->diskon) }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Biaya Admin</label>
                            <input type="number" step="0.01" name="adm_fee" class="form-control" value="{{ old('adm_fee', $invoice->adm_fee) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="partial" {{ $invoice->status == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
