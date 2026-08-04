<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Tambah Layanan Pelanggan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('customer-services.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="cust_id">Pelanggan</label>
                        <select name="cust_id" id="cust_id" class="form-control @error('cust_id') is-invalid @enderror" required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('cust_id') == $customer->id ? 'selected' : '' }}>{{ $customer->cust_code }} - {{ $customer->nama }}</option>
                            @endforeach
                        </select>
                        @error('cust_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pack_id">Paket Internet</label>
                        <select name="pack_id" id="pack_id" class="form-control @error('pack_id') is-invalid @enderror" required>
                            <option value="">Pilih Paket</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" {{ old('pack_id') == $package->id ? 'selected' : '' }}>{{ $package->nama_paket }}</option>
                            @endforeach
                        </select>
                        @error('pack_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="router_id">Router</label>
                        <select name="router_id" id="router_id" class="form-control @error('router_id') is-invalid @enderror" required>
                            <option value="">Pilih Router</option>
                            @foreach ($routers as $router)
                                <option value="{{ $router->id }}" {{ old('router_id') == $router->id ? 'selected' : '' }}>{{ $router->nama_router }}</option>
                            @endforeach
                        </select>
                        @error('router_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="usn">Username</label>
                        <input type="text" name="usn" id="usn" class="form-control @error('usn') is-invalid @enderror" value="{{ old('usn') }}" required>
                        @error('usn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="text" name="pass" id="pass" class="form-control @error('pass') is-invalid @enderror" value="{{ old('pass') }}" required>
                        @error('pass')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ip_address">IP Address</label>
                        <input type="text" name="ip_address" id="ip_address" class="form-control @error('ip_address') is-invalid @enderror" value="{{ old('ip_address') }}">
                        @error('ip_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="mac_address">MAC Address</label>
                        <input type="text" name="mac_address" id="mac_address" class="form-control @error('mac_address') is-invalid @enderror" value="{{ old('mac_address') }}">
                        @error('mac_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="act_date">Tanggal Aktif</label>
                        <input type="date" name="act_date" id="act_date" class="form-control @error('act_date') is-invalid @enderror" value="{{ old('act_date') }}">
                        @error('act_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exp_date">Tanggal Expire</label>
                        <input type="date" name="exp_date" id="exp_date" class="form-control @error('exp_date') is-invalid @enderror" value="{{ old('exp_date') }}">
                        @error('exp_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status Layanan</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="isolir" {{ old('status') === 'isolir' ? 'selected' : '' }}>Isolir</option>
                            <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('customer-services.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
