<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Tambah Catatan Penagihan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('collections.store') }}" method="POST">
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
                            <label>Collector</label>
                            <select name="coll_id" class="form-control" required>
                                <option value="">Pilih collector</option>
                                @foreach ($collectors as $collector)
                                    <option value="{{ $collector->id }}">{{ $collector->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal Kunjungan</label>
                            <input type="date" name="visit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="SUCCESS">SUCCESS</option>
                                <option value="NOT_HOME">NOT_HOME</option>
                                <option value="PROMISE_TO_PAY">PROMISE_TO_PAY</option>
                                <option value="REJECTED">REJECTED</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Catatan</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Latitude</label>
                            <input type="number" step="0.0000001" name="latitude" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Longitude</label>
                            <input type="number" step="0.0000001" name="longitude" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Foto</label>
                            <input type="text" name="foto" class="form-control" placeholder="path/file.jpg">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
