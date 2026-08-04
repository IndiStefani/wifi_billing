<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'branch_id', 'kode_area', 'nama_area', 'keterangan', 'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function collectors()
    {
        return $this->belongsToMany(Collector::class, 'area_collectors')
            ->withPivot('start_date', 'end_date', 'status')
            ->withTimestamps();
    }

    public function areaCollectors()
    {
        return $this->hasMany(AreaCollector::class);
    }
}
