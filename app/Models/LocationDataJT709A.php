<?php

namespace App\Models;

class LocationDataJT709A
{
    private $lockEvent;
    private $gsmSignal;
    private $gpsSignal;
    private $battery;
    private $voltage;
    private $protocolVersion;
    private $mcc;
    private $mnc;
    private $cellId;
    private $lac;
    private $fenceId;
    private $mileage;

    // Add getters and setters for all properties
    public function setLockEvent($event) { $this->lockEvent = $event; }
    public function setGSMSignal($signal) { $this->gsmSignal = $signal; }
    public function setGpsSignal($signal) { $this->gpsSignal = $signal; }
    public function setBattery($battery) { $this->battery = $battery; }
    public function setVoltage($voltage) { $this->voltage = $voltage; }
    public function setProtocolVersion($version) { $this->protocolVersion = $version; }
    public function setMCC($mcc) { $this->mcc = $mcc; }
    public function setMNC($mnc) { $this->mnc = $mnc; }
    public function setCELLID($cellId) { $this->cellId = $cellId; }
    public function setLAC($lac) { $this->lac = $lac; }
    public function setFenceId($fenceId) { $this->fenceId = $fenceId; }
    public function setMileage($mileage) { $this->mileage = $mileage; }
}
