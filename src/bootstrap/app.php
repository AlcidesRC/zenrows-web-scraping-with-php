<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Cli\Scrapper;
use App\FileSystem\CsvFile;
use App\Helpers;

$metrics = [
    'memory' => ['start' => memory_get_usage()  , 'end' => 0],
    'time'   => ['start' => microtime(true)     , 'end' => 0],
];

$printLine = static function (string $line): void {
    echo $line . PHP_EOL;
};

//---

$config = include __DIR__ . '/../config/app.php';

if ($argc === 2) {
    $config['concurrency'] = (int) $argv[1];
}

$printLine(sprintf(
    '- Scrapping [ %s ] with [ %d ] concurrent requests...',
    $config['guzzle_client']['base_uri'],
    $config['concurrency']
));

CsvFile::saveTo(
    filepath: $config['output'],
    headers: ['URL', 'Image', 'Name', 'Price'],
    lines: (new Scrapper)->setup($config)->processWholeShopWithConcurrency()
);

//---

$metrics['time']['end']   = microtime(true);
$metrics['memory']['end'] = memory_get_usage();

$printLine(sprintf(
    '- Elapsed time: %s',
    Helpers::readableTime($metrics['time']['end'] - $metrics['time']['start'])
));
$printLine(sprintf(
    '- Consumed memory: %s',
    Helpers::readableBytes($metrics['memory']['end'] - $metrics['memory']['start'])
));
$printLine(sprintf(
    '- CSV generated at: %s',
    $config['output']
));
