<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';

    protected $fillable = [
        'inv_id', 'coll_id', 'visit_date', 'status', 'note',
        'latitude', 'longitude', 'foto',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'inv_id');
    }

    public function collector()
    {
        return $this->belongsTo(Collector::class, 'coll_id');
    }
}
