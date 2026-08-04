<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaCollector extends Model
{
    protected $table = 'area_collectors';

    protected $fillable = [
        'area_id', 'collector_id', 'start_date', 'end_date', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }
}
