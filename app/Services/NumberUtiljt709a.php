<?php

namespace App\Services;

class NumberUtiljt709a
{
    const COORDINATE_PRECISION = 0.000001;
    const COORDINATE_FACTOR = 1000000;
    const ONE_PRECISION = 0.1;

    private function __construct() {}

    /**
     * Format the message ID as a hexadecimal string.
     *
     * @param int $msgId The message ID.
     * @return string The formatted message ID.
     */
    public static function formatMessageId($msgId)
    {
        return sprintf("0x%04x", $msgId);
    }

    /**
     * Format a short number as a hexadecimal string.
     *
     * @param int $num The number to format.
     * @return string The formatted number.
     */
    public static function formatShortNum($num)
    {
        return sprintf("0x%02x", $num);
    }

    /**
     * Convert a number to a hexadecimal string.
     *
     * @param int $num The number to convert.
     * @return string The hexadecimal string.
     */
    public static function hexStr($num)
    {
        return strtoupper(sprintf("%04x", $num));
    }

    /**
     * Parse the short bits of a number into an array.
     *
     * @param int $number The number to parse.
     * @return array The array of bits.
     */
    public static function parseShortBits($number)
    {
        $bits = [];
        for ($i = 0; $i < 16; $i++) {
            if (self::getBitValue($number, $i) == 1) {
                $bits[] = $i;
            }
        }
        return $bits;
    }

    /**
     * Parse the integer bits of a number into an array.
     *
     * @param int $number The number to parse.
     * @return array The array of bits.
     */
    public static function parseIntegerBits($number)
    {
        $bits = [];
        for ($i = 0; $i < 32; $i++) {
            if (self::getBitValue($number, $i) == 1) {
                $bits[] = $i;
            }
        }
        return $bits;
    }

    /**
     * Get the bit value at a specific index.
     *
     * @param int $number The number to check.
     * @param int $index The index of the bit.
     * @return int The bit value (0 or 1).
     */
    public static function getBitValue($number, $index)
    {
        return ($number & (1 << $index)) > 0 ? 1 : 0;
    }

    /**
     * Convert an array of bits to an integer.
     *
     * @param array $bits The array of bits.
     * @param int $len The length of the bit array.
     * @return int The integer representation.
     */
    public static function bitsToInt($bits, $len)
    {
        if (empty($bits)) {
            return 0;
        }

        $chars = array_fill(0, $len, '0');
        for ($i = 0; $i < $len; $i++) {
            $chars[$len - 1 - $i] = in_array($i, $bits) ? '1' : '0';
        }
        return bindec(implode('', $chars));
    }

    /**
     * Convert an array of bits to a long integer.
     *
     * @param array $bits The array of bits.
     * @param int $len The length of the bit array.
     * @return int The long integer representation.
     */
    public static function bitsToLong($bits, $len)
    {
        if (empty($bits)) {
            return 0;
        }

        $chars = array_fill(0, $len, '0');
        for ($i = 0; $i < $len; $i++) {
            $chars[$len - 1 - $i] = in_array($i, $bits) ? '1' : '0';
        }
        return bindec(implode('', $chars));
    }

    /**
     * Multiply a long number by a precision factor.
     *
     * @param int $longNum The long number.
     * @param float $precision The precision factor.
     * @return float The result of the multiplication.
     */
    public static function multiply($longNum, $precision)
    {
        return $longNum * $precision;
    }
}

?>
