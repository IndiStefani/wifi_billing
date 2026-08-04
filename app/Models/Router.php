<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Router extends Model
{
    protected $fillable = [
        'branch_id', 'nama_router', 'ip_address', 'api_port',
        'username', 'password', 'lokasi', 'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customerServices()
    {
        return $this->hasMany(CustomerService::class);
    }

    public function monitoringSessions()
    {
        return $this->hasMany(MonitoringSession::class);
    }
}
