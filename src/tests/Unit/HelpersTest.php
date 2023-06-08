<?php

declare(strict_types=1);

namespace UnitTests;

use App\Helpers;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class HelpersTest extends TestCase
{
    /**
     * @covers \App\Helpers::readableTime
     *
     * @dataProvider dataProviderForMethodReadableTime
     */
    public function testMethodReadableTime(float $number, string $expected): void
    {
        $result = Helpers::readableTime($number);

        static::assertEquals($result, $expected);
    }

    public function dataProviderForMethodReadableTime(): array
    {
        return [
            [10, '00:00:10.0'],
            [3601.2345, '01:00:01.2345'],
        ];
    }

    /**
     * @covers \App\Helpers::readableBytes
     *
     * @dataProvider dataProviderForMethodReadableBytes
     */
    public function testMethodReadableBytes(float $number, string $expected): void
    {
        $result = Helpers::readableBytes($number);

        static::assertEquals($result, $expected);
    }

    public function dataProviderForMethodReadableBytes(): array
    {
        return [
            [0, '0.00 B'],
            [123, '123.00 B'],
            [1024, '1.00 KB'],
            [2540000, '2.42 MB'],
            [8590000000000, '7.81 TB'],
        ];
    }
}
