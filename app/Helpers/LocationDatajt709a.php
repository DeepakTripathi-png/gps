<?php

namespace App\Helpers;

use App\Models\LockEventjt709a;

class LocationDatajt709a
{
    private $DataLength;
    private $GpsTime;
    private $Latitude;
    private $Longitude;
    private $LocationType;
    private $Speed;
    private $Direction;
    private $Mileage;
    private $Altitude;
    private $GpsSignal;
    private $GSMSignal;
    private $Battery;
    private $Voltage;
    private $LockStatus;
    private $LockRope;
    private $BackCover;
    private $ProtocolVersion;
    private $FenceId;
    private $MCC;
    private $MNC;
    private $LAC;
    private $CELLID;
    private $Awaken;
    private $Alarm;
    private $LockEvent;
    private $Index;

    public function __construct(
        $DataLength = 0, 
        $GpsTime = '', 
        $Latitude = 0.0, 
        $Longitude = 0.0, 
        $LocationType = 0, 
        $Speed = 0, 
        $Direction = 0, 
        $Mileage = 0, 
        $Altitude = 0, 
        $GpsSignal = 0, 
        $GSMSignal = 0, 
        $Battery = 0, 
        $Voltage = 0.0, 
        $LockStatus = 0, 
        $LockRope = 0, 
        $BackCover = 0, 
        $ProtocolVersion = 0, 
        $FenceId = 0, 
        $MCC = 0, 
        $MNC = 0, 
        $LAC = 0, 
        $CELLID = 0, 
        $Awaken = 0, 
        $Alarm = 0, 
        LockEventjt709a $LockEvent = null, 
        $Index = 0
    ) {
        $this->DataLength = $DataLength;
        $this->GpsTime = $GpsTime;
        $this->Latitude = $Latitude;
        $this->Longitude = $Longitude;
        $this->LocationType = $LocationType;
        $this->Speed = $Speed;
        $this->Direction = $Direction;
        $this->Mileage = $Mileage;
        $this->Altitude = $Altitude;
        $this->GpsSignal = $GpsSignal;
        $this->GSMSignal = $GSMSignal;
        $this->Battery = $Battery;
        $this->Voltage = $Voltage;
        $this->LockStatus = $LockStatus;
        $this->LockRope = $LockRope;
        $this->BackCover = $BackCover;
        $this->ProtocolVersion = $ProtocolVersion;
        $this->FenceId = $FenceId;
        $this->MCC = $MCC;
        $this->MNC = $MNC;
        $this->LAC = $LAC;
        $this->CELLID = $CELLID;
        $this->Awaken = $Awaken;
        $this->Alarm = $Alarm;
        $this->LockEvent = $LockEvent;
        $this->Index = $Index;
    }

    // Getters
    public function getDataLength() {
        return $this->DataLength;
    }

    public function getGpsTime() {
        return $this->GpsTime;
    }

    public function getLatitude() {
        return $this->Latitude;
    }

    public function getLongitude() {
        return $this->Longitude;
    }

    public function getLocationType() {
        return $this->LocationType;
    }

    public function getSpeed() {
        return $this->Speed;
    }

    public function getDirection() {
        return $this->Direction;
    }

    public function getMileage() {
        return $this->Mileage;
    }

    public function getAltitude() {
        return $this->Altitude;
    }

    public function getGpsSignal() {
        return $this->GpsSignal;
    }

    public function getGSMSignal() {
        return $this->GSMSignal;
    }

    public function getBattery() {
        return $this->Battery;
    }

    public function getVoltage() {
        return $this->Voltage;
    }

    public function getLockStatus() {
        return $this->LockStatus;
    }

    public function getLockRope() {
        return $this->LockRope;
    }

    public function getBackCover() {
        return $this->BackCover;
    }

    public function getProtocolVersion() {
        return $this->ProtocolVersion;
    }

    public function getFenceId() {
        return $this->FenceId;
    }

    public function getMCC() {
        return $this->MCC;
    }

    public function getMNC() {
        return $this->MNC;
    }

    public function getLAC() {
        return $this->LAC;
    }

    public function getCELLID() {
        return $this->CELLID;
    }

    public function getAwaken() {
        return $this->Awaken;
    }

    public function getAlarm() {
        return $this->Alarm;
    }

    public function getLockEvent() {
        return $this->LockEvent;
    }

    public function getIndex() {
        return $this->Index;
    }

    // Setters
    public function setDataLength($DataLength) {
        $this->DataLength = $DataLength;
    }

    public function setGpsTime($GpsTime) {
        $this->GpsTime = $GpsTime;
    }

    public function setLatitude($Latitude) {
        $this->Latitude = $Latitude;
    }

    public function setLongitude($Longitude) {
        $this->Longitude = $Longitude;
    }

    public function setLocationType($LocationType) {
        $this->LocationType = $LocationType;
    }

    public function setSpeed($Speed) {
        $this->Speed = $Speed;
    }

    public function setDirection($Direction) {
        $this->Direction = $Direction;
    }

    public function setMileage($Mileage) {
        $this->Mileage = $Mileage;
    }

    public function setAltitude($Altitude) {
        $this->Altitude = $Altitude;
    }

    public function setGpsSignal($GpsSignal) {
        $this->GpsSignal = $GpsSignal;
    }

    public function setGSMSignal($GSMSignal) {
        $this->GSMSignal = $GSMSignal;
    }

    public function setBattery($Battery) {
        $this->Battery = $Battery;
    }

    public function setVoltage($Voltage) {
        $this->Voltage = $Voltage;
    }

    public function setLockStatus($LockStatus) {
        $this->LockStatus = $LockStatus;
    }

    public function setLockRope($LockRope) {
        $this->LockRope = $LockRope;
    }

    public function setBackCover($BackCover) {
        $this->BackCover = $BackCover;
    }

    public function setProtocolVersion($ProtocolVersion) {
        $this->ProtocolVersion = $ProtocolVersion;
    }

    public function setFenceId($FenceId) {
        $this->FenceId = $FenceId;
    }

    public function setMCC($MCC) {
        $this->MCC = $MCC;
    }

    public function setMNC($MNC) {
        $this->MNC = $MNC;
    }

    public function setLAC($LAC) {
        $this->LAC = $LAC;
    }

    public function setCELLID($CELLID) {
        $this->CELLID = $CELLID;
    }

    public function setAwaken($Awaken) {
        $this->Awaken = $Awaken;
    }

    public function setAlarm($Alarm) {
        $this->Alarm = $Alarm;
    }

    public function setLockEvent($LockEvent) {
        $this->LockEvent = $LockEvent;
    }

    public function setIndex($Index) {
        $this->Index = $Index;
    }
}
