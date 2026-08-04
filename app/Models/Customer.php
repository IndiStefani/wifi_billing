<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'cust_code', 'branch_id', 'area_id', 'nama', 'email', 'telepon',
        'alamat', 'latitude', 'longitude', 'register_date', 'status',
    ];

    protected $casts = [
        'register_date' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function services()
    {
        return $this->hasMany(CustomerService::class, 'cust_id');
    }
}
