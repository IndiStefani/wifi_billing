<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Edit Pelanggan</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Pelanggan</h3>
                <a href="{{ route('customers.show', $customer) }}" class="btn btn-info">Lihat Detail</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="cust_code">Kode Pelanggan</label>
                        <input type="text" name="cust_code" id="cust_code" class="form-control @error('cust_code') is-invalid @enderror" value="{{ old('cust_code', $customer->cust_code) }}" required>
                        @error('cust_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="branch_id">Cabang</label>
                        <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required>
                            <option value="">Pilih Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $customer->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->nama }}</option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="area_id">Area</label>
                        <select name="area_id" id="area_id" class="form-control @error('area_id') is-invalid @enderror" required>
                            <option value="">Pilih Area</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id', $customer->area_id) == $area->id ? 'selected' : '' }}>{{ $area->branch->nama ?? '-' }} / {{ $area->nama_area }}</option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $customer->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $customer->telepon) }}">
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $customer->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register_date">Registrasi</label>
                        <input type="date" name="register_date" id="register_date" class="form-control @error('register_date') is-invalid @enderror" value="{{ old('register_date', optional($customer->register_date)->format('Y-m-d')) }}">
                        @error('register_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $customer->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Batal</a>
                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-info">Lihat Detail</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
