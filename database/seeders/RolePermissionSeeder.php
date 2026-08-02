<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'super-admin' => 'Super Admin',
            'admin' => 'Admin',
            'penagih' => 'Penagih',
            'teknisi' => 'Teknisi',
        ];

        $permissions = [
            'pelanggan' => 'Pelanggan',
            'billing' => 'Billing',
            'monitoring' => 'Monitoring',
            'router' => 'Router',
            'laporan' => 'Laporan',
            'manage roles' => 'Manage Roles',
            'manage users' => 'Manage Users',
            'daftar-tagihan' => 'Daftar Tagihan',
            'input-pembayaran' => 'Input Pembayaran',
            'riwayat-tagihan' => 'Riwayat Tagihan',
            'lokasi-customer' => 'Lokasi Customer',
        ];

        $roles = collect($roles)->mapWithKeys(fn ($label, $name) => [$name => Role::firstOrCreate(['name' => $name], ['label' => $label])]);
        $permissions = collect($permissions)->mapWithKeys(fn ($label, $name) => [$name => Permission::firstOrCreate(['name' => $name], ['label' => $label])]);

        $roles['admin']->permissions()->sync([
            $permissions['pelanggan']->id,
            $permissions['billing']->id,
            $permissions['monitoring']->id,
            $permissions['router']->id,
            $permissions['laporan']->id,
            $permissions['manage roles']->id,
            $permissions['manage users']->id,
        ]);

        $roles['penagih']->permissions()->sync([
            $permissions['daftar-tagihan']->id,
            $permissions['input-pembayaran']->id,
            $permissions['riwayat-tagihan']->id,
            $permissions['lokasi-customer']->id,
        ]);

        $roles['teknisi']->permissions()->sync([
            $permissions['monitoring']->id,
        ]);

        $roles['super-admin']->permissions()->sync($permissions->pluck('id')->all());

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678'),
            ]
        );

        $superAdmin->roles()->syncWithoutDetaching([$roles['super-admin']->id]);

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'),
            ]
        )->roles()->syncWithoutDetaching([$roles['admin']->id]);

        User::firstOrCreate(
            ['email' => 'penagih@example.com'],
            [
                'name' => 'Penagih User',
                'password' => bcrypt('12345678'),
            ]
        )->roles()->syncWithoutDetaching([$roles['penagih']->id]);

        User::firstOrCreate(
            ['email' => 'teknisi@example.com'],
            [
                'name' => 'Teknisi User',
                'password' => bcrypt('12345678'),
            ]
        )->roles()->syncWithoutDetaching([$roles['teknisi']->id]);
    }
}
