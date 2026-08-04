<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringSession extends Model
{
    protected $fillable = [
        'cust_serv_id', 'router_id', 'login_time', 'logout_time',
        'uptime', 'ip_address', 'mac_address', 'download', 'upload', 'status',
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
    ];

    public function customerService()
    {
        return $this->belongsTo(CustomerService::class, 'cust_serv_id');
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }
}
