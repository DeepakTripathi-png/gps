<?php

namespace App\Models;

class SensorData
{
    private $gpsZonedDateTime;
    private $lat;
    private $lng;
    private $locationType;
    private $speed;
    private $direction;
    private $slaveMachineZonedDateTime;
    private $slaveMachineId;
    private $flowId;
    private $voltage;
    private $power;
    private $rssi;
    private $sensorType;
    private $temperature;
    private $humidity;
    private $eventType;
    private $terminalStatus;
    private $lockTimes;
    private $gatewayStatus;

    // Getters and Setters for each property

    public function getGpsZonedDateTime()
    {
        return $this->gpsZonedDateTime;
    }

    public function setGpsZonedDateTime($gpsZonedDateTime)
    {
        $this->gpsZonedDateTime = $gpsZonedDateTime;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    public function getLocationType()
    {
        return $this->locationType;
    }

    public function setLocationType($locationType)
    {
        $this->locationType = $locationType;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    public function getSlaveMachineZonedDateTime()
    {
        return $this->slaveMachineZonedDateTime;
    }

    public function setSlaveMachineZonedDateTime($slaveMachineZonedDateTime)
    {
        $this->slaveMachineZonedDateTime = $slaveMachineZonedDateTime;
    }

    public function getSlaveMachineId()
    {
        return $this->slaveMachineId;
    }

    public function setSlaveMachineId($slaveMachineId)
    {
        $this->slaveMachineId = $slaveMachineId;
    }

    public function getFlowId()
    {
        return $this->flowId;
    }

    public function setFlowId($flowId)
    {
        $this->flowId = $flowId;
    }

    public function getVoltage()
    {
        return $this->voltage;
    }

    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function setPower($power)
    {
        $this->power = $power;
    }

    public function getRssi()
    {
        return $this->rssi;
    }

    public function setRssi($rssi)
    {
        $this->rssi = $rssi;
    }

    public function getSensorType()
    {
        return $this->sensorType;
    }

    public function setSensorType($sensorType)
    {
        $this->sensorType = $sensorType;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }

    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;
    }

    public function getEventType()
    {
        return $this->eventType;
    }

    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
    }

    public function getTerminalStatus()
    {
        return $this->terminalStatus;
    }

    public function setTerminalStatus($terminalStatus)
    {
        $this->terminalStatus = $terminalStatus;
    }

    public function getLockTimes()
    {
        return $this->lockTimes;
    }

    public function setLockTimes($lockTimes)
    {
        $this->lockTimes = $lockTimes;
    }

    public function getGatewayStatus()
    {
        return $this->gatewayStatus;
    }

    public function setGatewayStatus($gatewayStatus)
    {
        $this->gatewayStatus = $gatewayStatus;
    }
}
