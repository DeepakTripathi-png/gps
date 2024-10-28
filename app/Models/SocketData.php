<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketData extends Model
{
    use HasFactory;
    
      protected $fillable = [
              'device_id',
             'latitude', 
            'longitude',
           'battery_level',
            'timestamp',
            'vin',
            'geofence_enter', 
           'geofence_exit',
           'power_cut',
           'vibration',
           'fall_down',
           'ignition',
           'jamming',
            'tow',
            'removing',
           'low_battery',
           'tampering',
            'power_restored',
           'fault',
           'bit14',
           'bit15',
          'bit16',
           'address',
            'command_word',
           'date',
           'time',
            'speed',
            'direction',
            'event_source_type',
            'unlock_verification',
            'rfid_card_number',
           'password_verification',
            'incorrect_password',
            'event_serial_number',
            'mileage',
           'fenceid',
    ];
    
    
    
}
