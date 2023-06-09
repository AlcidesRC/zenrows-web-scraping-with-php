<?php

declare(strict_types=1);

namespace UnitTests\Cli;

use App\Cli\Scrapper;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 *
 * @phpstan-type DataProviderEntry array{string, string, string, string}
 */
final class ScrapperTest extends TestCase
{
    /**
     * @var array<string, array<int, int>|int|string> $config
     */
    private array $config;

    protected function setUp(): void
    {
        $this->config                = include(__DIR__ . '/../../../config/app.php');
        $this->config['output']      = '/dev/null';
        $this->config['concurrency'] = 1;
    }

    protected function tearDown(): void
    {
        unset($this->config);
    }

    /**
     * @covers \App\Cli\Scrapper::setup
     * @covers \App\Cli\Scrapper::processWholeShopWithConcurrency
     * @covers \App\Http\UserAgents::getRandom
     *
     * @dataProvider dataProviderForMethodMethodProcessWholeShopWithConcurrency
     *
     * @param array{string, string, string, string} $fixture
     */
    public function testMethodProcessWholeShopWithConcurrency(int $page, array $fixture): void
    {
        // @phpstan-ignore-next-line
        $mock = $this->createPartialMock(Scrapper::class, ['getMaxPage']);
        $mock->expects($this->once())->method('getMaxPage')->willReturn($page);

        $result = $mock->setup($this->config)->processWholeShopWithConcurrency();

        $this->assertEquals($fixture, $result);
    }

    /**
     * @return array<int, DataProviderEntry>
     */
    public function dataProviderForMethodMethodProcessWholeShopWithConcurrency(): array
    {
        $loadFixture = static function (int $page): array {
            $contents = (string) file_get_contents(
                __DIR__ . sprintf('/../../Fixture/Cli/ScrapperTest/page-%d.serialized', $page)
            );

            return (array) unserialize($contents);
        };

        $randomPage = random_int(3, 5);

        return [
            // Explicit checkpoints
            [1, $loadFixture(1)],
            [2, $loadFixture(2)],

            // Random checkpoints
            [$randomPage, $loadFixture($randomPage)],
        ];
    }

    /**
     * @covers \App\Cli\Scrapper::setup
     * @covers \App\Cli\Scrapper::getMaxPage
     * @covers \App\Http\UserAgents::getRandom
     */
    public function testMethodGetMaxPage(): void
    {
        $result = (new Scrapper())->setup($this->config)->getMaxPage();

        $this->assertEquals(48, $result);
    }
}
