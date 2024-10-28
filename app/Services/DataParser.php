<?php

namespace App\Services;

use App\Constants\Constant;
use App\Utils\ParserUtil;

class HexDataService
{
    public function receiveDataFromHex(string $strData): ?string
    {
        // $bytes = self::hexStr2Byte($strData);
        // return $this->receiveDataFromBytes($bytes);

        return 'Hello';
    }

    private function receiveDataFromBytes(string $bytes): ?string
    {
        return $this->receiveDataFromBuffer($bytes);
    }

    private function receiveDataFromBuffer(string $buffer): ?string
    {
        $decoded = null;
        $header = ord($buffer[0]);

        if ($header === Constant::TEXT_MSG_HEADER) {
            $decoded = ParserUtil::decodeTextMessage($buffer);
        } elseif ($header === Constant::BINARY_MSG_HEADER) {
            $decoded = ParserUtil::decodeBinaryMessage($buffer);
        } else {
            return null;
        }

        return json_encode($decoded);
    }

    private static function hexStr2Byte(string $hex): string
    {
        $bytes = '';
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $bytes .= chr(hexdec(substr($hex, $i, 2)));
        }

        return $bytes;
    }
}
