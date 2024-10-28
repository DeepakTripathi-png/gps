<?php

namespace App\Constants;

/**
 * Class Constant
 * Constant definitions
 * @author HyoJung
 * @date 20210526
 */
class Constant
{
    // Prevent instantiation
    private function __construct()
    {
    }

    /**
     * Binary message header
     */
    public const BINARY_MSG_HEADER = '$';

    /**
     * Text message header
     */
    public const TEXT_MSG_HEADER = '(';

    /**
     * Text message trailer
     */
    public const TEXT_MSG_TAIL = ')';

    /**
     * Text message separator
     */
    public const TEXT_MSG_SPLITTER = ',';

    /**
     * Instructions for transparently transmitting binary data
     */
    public const WLNET_TYPE_LIST = ['5', '7'];
}
