<?php

namespace App\Helpers;

class LockEventjt709a
{
    // Properties
    public $Type;
    public $CardNo;
    public $Password;
    public $UnLockStatus = 0;
    public $FenceId = -1;

    // Constructor to initialize properties if needed
    public function __construct(
        $Type = 0, 
        $CardNo = '', 
        $Password = '', 
        $UnLockStatus = 0, 
        $FenceId = -1
    ) {
        $this->Type = $Type;
        $this->CardNo = $CardNo;
        $this->Password = $Password;
        $this->UnLockStatus = $UnLockStatus;
        $this->FenceId = $FenceId;
    }
}
