<?php

namespace App\Helpers;

use Serializable;

class Resultjt709a implements Serializable
{
    private $DeviceID;
    private $MsgType;
    private $DataBody;
    private $ReplyMsg;

    public function getDeviceID()
    {
        return $this->DeviceID;
    }

    public function setDeviceID($DeviceID)
    {
        $this->DeviceID = $DeviceID;
    }

    public function getMsgType()
    {
        return $this->MsgType;
    }

    public function setMsgType($MsgType)
    {
        $this->MsgType = $MsgType;
    }

    public function getDataBody()
    {
        return $this->DataBody;
    }

    public function setDataBody($DataBody)
    {
        $this->DataBody = $DataBody;
    }

    public function getReplyMsg()
    {
        return $this->ReplyMsg;
    }

    public function setReplyMsg($ReplyMsg)
    {
        $this->ReplyMsg = $ReplyMsg;
    }

    // Serializable methods
    public function serialize()
    {
        return serialize([
            $this->DeviceID,
            $this->MsgType,
            $this->DataBody,
            $this->ReplyMsg,
        ]);
    }

    public function unserialize($data)
    {
        [
            $this->DeviceID,
            $this->MsgType,
            $this->DataBody,
            $this->ReplyMsg,
        ] = unserialize($data);
    }
}
