<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'inv_id', 'tanggal', 'metode', 'jumlah', 'reference', 'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'inv_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
