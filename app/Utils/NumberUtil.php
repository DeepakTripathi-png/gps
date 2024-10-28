<?php

namespace App\Utils;

class NumberUtil
{
    /**
     * Get the bit value at a specific position.
     *
     * @param int $number The number to check.
     * @param int $bitPosition The position of the bit to check (0-based index).
     *
     * @return int 1 if the bit is set, 0 otherwise.
     */
    public static function getBitValue($number, $bitPosition)
    {
        // Shift the bit to the right by $bitPosition and mask with 1
        return ($number >> $bitPosition) & 1;
    }
}
