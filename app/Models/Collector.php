<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    protected $fillable = [
        'nama', 'alamat', 'telepon', 'status',
    ];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_collectors')
            ->withPivot('start_date', 'end_date', 'status')
            ->withTimestamps();
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'coll_id');
    }
}
