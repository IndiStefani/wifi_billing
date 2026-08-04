<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternetPacket extends Model
{
    protected $table = 'internet_packet';

    protected $fillable = [
        'nama_paket', 'bandwidth', 'harga', 'deskripsi', 'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function customerServices()
    {
        return $this->hasMany(CustomerService::class, 'pack_id');
    }
}
