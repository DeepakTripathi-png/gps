<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GpsDevice extends Model
{
    use HasFactory;
    protected $fillable = ['device_id','device_type','sim_no','sim_no_two','password','imei_no','swipe_cardone','swipe_cardtwo','status','asset_no','expiry_date','updated_by','created_by','display'];

    public function assignTrips()
    {
        return $this->hasMany(AssignTrip::class, 'gps_devices_id', 'id');
    }
}
