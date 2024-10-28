<?php

namespace App\Helpers;

class AlarmTypeEnumjt709a
{
    const ALARM_1 = 'Over Speed Alarm';
    const ALARM_2 = 'Low Battery Alarm';
    const ALARM_3 = 'Main Engine Cover Open Alarm';
    const ALARM_4 = 'Entering Fence Alarm';
    const ALARM_5 = 'Exiting Fence Alarm';

    private static $alarmTypes = [
        '1' => self::ALARM_1,
        '2' => self::ALARM_2,
        '3' => self::ALARM_3,
        '4' => self::ALARM_4,
        '5' => self::ALARM_5,
    ];

    public static function fromValue(string $value): ?string
    {
        return self::$alarmTypes[$value] ?? null;
    }

    public static function getDesc(string $value): ?string
    {
        return self::fromValue($value);
    }
}
  
