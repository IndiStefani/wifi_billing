<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'inv_number', 'cust_serv_id', 'periode', 'nominal', 'diskon',
        'adm_fee', 'total', 'due_date', 'status', 'paid_at',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'adm_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function customerService()
    {
        return $this->belongsTo(CustomerService::class, 'cust_serv_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'inv_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'inv_id');
    }
}
