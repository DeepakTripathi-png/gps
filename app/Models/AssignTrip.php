<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTrip extends Model
{
    protected $casts = [
        'container_details' => 'object',
        'shipping_details' => 'object'
    ];

    use HasFactory;
   

    protected $table = 'assign_trips';

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_destination');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_destination');
    }

    public function gpsDevice()
    {
        return $this->belongsTo(GPSDevice::class, 'gps_devices_id');
    }

    public function scopeEnable($query)
    {
        return $query->where('status', 'enable');
    }
    
}