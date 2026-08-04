<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'telepon', 'status',
    ];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function routers()
    {
        return $this->hasMany(Router::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
