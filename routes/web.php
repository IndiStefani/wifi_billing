<?php

use App\Http\Controllers\AreaCollectorController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\InternetPacketController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->except(['show']);

    Route::get('roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RolePermissionController::class, 'createRole'])->name('roles.create');
    Route::post('roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::get('roles/{role}/edit', [RolePermissionController::class, 'editRole'])->name('roles.edit');
    Route::patch('roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::post('roles/{role}/permissions', [RolePermissionController::class, 'assignPermissions'])->name('roles.permissions.assign');

    Route::get('permissions/create', [RolePermissionController::class, 'createPermission'])->name('permissions.create');
    Route::post('permissions', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
    Route::get('permissions/{permission}/edit', [RolePermissionController::class, 'editPermission'])->name('permissions.edit');
    Route::patch('permissions/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
    Route::delete('permissions/{permission}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');

    Route::resource('internet-packets', InternetPacketController::class)->except(['show']);
    Route::resource('branches', BranchController::class)->except(['show']);
    Route::resource('areas', AreaController::class)->except(['show']);
    Route::resource('collectors', CollectorController::class)->except(['show']);
    Route::resource('area-collectors', AreaCollectorController::class)->except(['show']);
    Route::resource('customers', CustomerController::class);
    Route::get('customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::resource('customer-services', CustomerServiceController::class)->except(['show']);

    Route::resource('invoices', InvoiceController::class)->except(['show']);
    Route::resource('payments', PaymentController::class)->except(['show']);
    Route::resource('collections', CollectionController::class)->except(['show']);
});

require __DIR__.'/auth.php';
