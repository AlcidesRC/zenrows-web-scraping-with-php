<?php

declare(strict_types=1);

namespace App;

final class Helpers
{
    private const MEMORY_SIZE_UNITS_MAP = [
        'YB' => 8,
        'ZB' => 7,
        'EB' => 6,
        'PB' => 5,
        'TB' => 4,
        'GB' => 3,
        'MB' => 2,
        'KB' => 1,
        'B'  => 0,
    ];

    public static function readableBytes(float $num): string
    {
        foreach (self::MEMORY_SIZE_UNITS_MAP as $unit => $exp) {
            if ($num >= pow(1024, $exp)) {
                break;
            }
        }

        return sprintf("%.2f %s", $num / pow(1024, $exp), $unit);
    }

    public static function readableTime(float $num): string
    {
        return sprintf(
            '%02d:%02d:%02d.%d',
            floor($num / 3600),
            (int) ($num / 60) % 60,
            (int) $num % 60,
            explode('.', number_format($num, 4))[1]
        );
    }
}
