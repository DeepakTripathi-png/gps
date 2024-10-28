<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socket_data', function (Blueprint $table) {
            $table->id();
             $table->string('device_id')->nullable();
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude with precision for GPS coordinates
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude with precision for GPS coordinates
            $table->integer('battery_level')->nullable(); // Battery level, if available
            $table->timestamp('timestamp')->nullable(); // Timestamp of the data packet
            $table->string('vin')->nullable(); // Vehicle Identification Number
            $table->string('geofence_enter')->nullable(); // Geofence enter event
            $table->string('geofence_exit')->nullable(); // Geofence exit event
            $table->string('power_cut')->nullable(); // Power cut event
            $table->string('vibration')->nullable(); // Vibration event
            $table->string('fall_down')->nullable(); // Fall down event
            $table->string('ignition')->nullable(); // Ignition event
            $table->string('jamming')->nullable(); // Jamming event
            $table->string('tow')->nullable(); // Tow event
            $table->string('removing')->nullable(); // Removing event
            $table->string('low_battery')->nullable(); // Low battery event
            $table->string('tampering')->nullable(); // Tampering event
            $table->string('power_restored')->nullable(); // Power restored event
            $table->string('fault')->nullable(); // Fault event
            $table->string('bit14')->nullable(); // Additional data bit 14
            $table->string('bit15')->nullable(); // Additional data bit 15
            $table->string('bit16')->nullable(); // Additional data bit 16
            $table->text('address')->nullable(); // Address information

            // Fields specific to the 'else' condition
            $table->string('command_word')->nullable(); // Command word
            $table->string('date')->nullable(); // Date from the packet
            $table->string('time')->nullable(); // Time from the packet
            $table->string('speed')->nullable(); // Speed from the packet
            $table->string('direction')->nullable(); // Direction from the packet
            $table->string('event_source_type')->nullable(); // Event source type
            $table->string('unlock_verification')->nullable(); // Unlock verification
            $table->string('rfid_card_number')->nullable(); // RFID card number
            $table->string('password_verification')->nullable(); // Password verification
            $table->string('incorrect_password')->nullable(); // Incorrect password
            $table->string('event_serial_number')->nullable(); // Event serial number
            $table->string('mileage')->nullable(); // Mileage from the packet
            $table->string('fenceid')->nullable(); // Fence ID
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socket_data');
    }
};
