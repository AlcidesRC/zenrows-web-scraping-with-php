<?php

declare(strict_types=1);

namespace UnitTests;

use App\Helpers;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 *
 * @phpstan-type DataProviderEntry1 array{float, string}
 * @phpstan-type DataProviderEntry2 array{int, string}
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

    /**
     * @return array<int, DataProviderEntry1>
     */
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

    /**
     * @return array<int, DataProviderEntry2>
     */
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
