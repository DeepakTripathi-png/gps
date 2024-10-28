<?php

namespace App\Utils;

class DataParser
{
    /**
     * Parse hexadecimal string data.
     *
     * @param string $strData
     * @return array|null
     */
    public static function receiveData(string $strData)
    {
        $bytes = CommonUtil::hexStr2Byte($strData);
        return self::receiveDataFromBytes($bytes);
    }

    /**
     * Parse data from byte array.
     *
     * @param array $bytes
     * @return array|null
     */
    private static function receiveDataFromBytes(array $bytes)
    {
        $header = $bytes[0]; // Example of extracting the header

        if ($header == Constant::TEXT_MSG_HEADER) {
            return ParserUtil::decodeTextMessage(implode('', array_map('chr', $bytes)));
        } elseif ($header == Constant::BINARY_MSG_HEADER) {
            return ParserUtil::decodeBinaryMessage(implode('', array_map('chr', $bytes)));
        } else {
            return null;
        }
    }
}
