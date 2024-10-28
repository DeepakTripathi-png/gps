<?php

namespace App\Helpers;

class Constantjt709a
{
    private function __construct() {} 

    const BINARY_MSG_HEADER = 0x7E; 
    const BINARY_MSG_BASE_LENGTH = 15; 
    const BINARY_MSG_MAX_LENGTH = 102400; 

    const TEXT_MSG_HEADER = '(';
    const TEXT_MSG_TAIL = ')'; 
    const TEXT_MSG_SPLITER = ','; 
}


