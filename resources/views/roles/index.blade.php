<x-app-layout>
    <x-slot name="header">
        <h1 class="m-0 text-dark">Manajemen Role & Permission</h1>
    </x-slot>

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">Tambah Role</a>
                <a href="{{ route('permissions.create') }}" class="btn btn-secondary">Tambah Permission</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="rolesTable" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Label</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->label }}</td>
                                        <td>
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus role ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada role.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permissions</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="permissionsTable" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Label</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->label }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus permission ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada permission.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assign Permission ke Role</h3>
            </div>
            <div class="card-body">
                @foreach ($roles as $role)
                    <div class="mb-4">
                        <h5>{{ $role->name }} <small class="text-muted">({{ $role->label }})</small></h5>
                        <form action="{{ route('roles.permissions.assign', $role) }}" method="POST">
                            @csrf
                            <div class="form-row">
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="perm_{{ $role->id }}_{{ $permission->id }}" value="{{ $permission->id }}" {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $role->id }}_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-sm btn-success mt-2">Simpan Permission</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                $('#rolesTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    ordering: true,
                    searching: true,
                    paging: true,
                });

                $('#permissionsTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    ordering: true,
                    searching: true,
                    paging: true,
                });
            });
        </script>
    @endpush
</x-app-layout>
