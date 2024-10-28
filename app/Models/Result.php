<?php

namespace App\Models;

class Result
{
    private $deviceID;
    private $msgType;
    private $dataBody;
    private $replyMsg;

    public function setDeviceID($deviceID)
    {
        $this->deviceID = $deviceID;
    }

    public function setMsgType($msgType)
    {
        $this->msgType = $msgType;
    }

    public function setDataBody($dataBody)
    {
        $this->dataBody = $dataBody;
    }

    public function setReplyMsg($replyMsg)
    {
        $this->replyMsg = $replyMsg;
    }

    public function getDeviceID()
    {
        return $this->deviceID;
    }

    public function getMsgType()
    {
        return $this->msgType;
    }

    public function getDataBody()
    {
        return $this->dataBody;
    }

    public function getReplyMsg()
    {
        return $this->replyMsg;
    }
}
