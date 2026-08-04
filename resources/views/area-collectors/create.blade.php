<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Tambah Wilayah Collector</h1>
    </x-slot>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('area-collectors.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="area_id">Area</label>
                        <select name="area_id" id="area_id" class="form-control @error('area_id') is-invalid @enderror" required>
                            <option value="">Pilih Area</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->branch->nama ?? '-' }} / {{ $area->nama_area }}</option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="collector_id">Collector</label>
                        <select name="collector_id" id="collector_id" class="form-control @error('collector_id') is-invalid @enderror" required>
                            <option value="">Pilih Collector</option>
                            @foreach ($collectors as $collector)
                                <option value="{{ $collector->id }}" {{ old('collector_id') == $collector->id ? 'selected' : '' }}>{{ $collector->nama }}</option>
                            @endforeach
                        </select>
                        @error('collector_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('area-collectors.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
