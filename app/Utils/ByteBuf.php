<?php

namespace App\Utils;

class ByteBuf
{
    private $data;
    private $position;

    public function __construct($data)
    {
        $this->data = $data;
        $this->position = 0;
    }

    public function readByte()
    {
        if ($this->position >= strlen($this->data)) {
            throw new \OutOfBoundsException('No more bytes to read');
        }
        return ord($this->data[$this->position++]);
    }

    public function readBytes($length)
    {
        if ($this->position + $length > strlen($this->data)) {
            throw new \OutOfBoundsException('Not enough bytes to read');
        }
        $bytes = substr($this->data, $this->position, $length);
        $this->position += $length;
        return $bytes;
    }

    public function readableBytes()
    {
        return strlen($this->data) - $this->position;
    }

    public function bytesBefore($byte)
    {
        $pos = strpos(substr($this->data, $this->position), chr($byte));
        return $pos === false ? 0 : $pos;
    }
}
