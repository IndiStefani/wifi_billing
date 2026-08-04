<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    protected $table = 'customers_services';

    protected $fillable = [
        'cust_id', 'pack_id', 'router_id', 'usn', 'pass',
        'ip_address', 'mac_address', 'act_date', 'exp_date', 'status',
    ];

    protected $hidden = [
        'pass',
    ];

    protected $casts = [
        'act_date' => 'date',
        'exp_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }

    public function package()
    {
        return $this->belongsTo(InternetPacket::class, 'pack_id');
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'cust_serv_id');
    }

    public function monitoringSessions()
    {
        return $this->hasMany(MonitoringSession::class, 'cust_serv_id');
    }
}
