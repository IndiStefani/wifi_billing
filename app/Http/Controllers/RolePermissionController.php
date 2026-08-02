<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('roles.index', compact('roles', 'permissions'));
    }

    public function createRole()
    {
        return view('roles.create');
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    public function editRole(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroyRole(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }

    public function createPermission()
    {
        return view('permissions.create');
    }

    public function storePermission(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        Permission::create($data);

        return redirect()->route('roles.index')->with('success', 'Permission berhasil dibuat.');
    }

    public function editPermission(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($data);

        return redirect()->route('roles.index')->with('success', 'Permission berhasil diperbarui.');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('roles.index')->with('success', 'Permission berhasil dihapus.');
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $data = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->permissions()->sync($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Permissions berhasil diperbarui.');
    }
}
