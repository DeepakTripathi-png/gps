<?php
namespace App\Helpers;

class ByteArrayInput {
    private $data;
    private $position;

    public function __construct($data) {
        $this->data = $data;
        $this->position = 0;
    }

    public function readableBytes() {
        return strlen($this->data) - $this->position;
    }

    public function readBytes($length) {
        $bytes = substr($this->data, $this->position, $length);
        $this->position += $length;
        return $bytes;
    }

    public function readByte() {
        return $this->readBytes(1);
    }

    public function bytesBefore($delimiter) {
        $position = strpos(substr($this->data, $this->position), $delimiter);
        return $position !== false ? $position : strlen($this->data) - $this->position;
    }
}


