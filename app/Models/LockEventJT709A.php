<?php

namespace App\Models;

class LockEvent
{
    private $type;
    private $password;
    private $unlockStatus;
    private $cardNo;
    private $fenceId;

    // Add getters and setters for all properties
    public function setType($type) { $this->type = $type; }
    public function setPassword($password) { $this->password = $password; }
    public function setUnLockStatus($status) { $this->unlockStatus = $status; }
    public function setCardNo($cardNo) { $this->cardNo = $cardNo; }
    public function setFenceId($fenceId) { $this->fenceId = $fenceId; }
}
