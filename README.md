# Web Scraping with PHP

[![Integration Tests](https://github.com/AlcidesRC/zenrows-web-scraping-with-php/actions/workflows/integration-tests.yml/badge.svg)](https://github.com/AlcidesRC/zenrows-web-scraping-with-php/actions/workflows/integration-tests.yml)

[TOC]

## Summary

This repository contains an implementation of [Web Scraping with PHP: step-by-step tutorial](https://www.zenrows.com/blog/web-scraping-php) by [Zenrows](https://www.zenrows.com/) but **using Guzzle and concurrent requests** to improve the performance.

Docker image and service implementation is based on [Dockerized PHP CLI](https://github.com/fonil/dockerized-php-cli), a lightweight skeleton for PHP CLI microservices.

> For further details about Requirements, Getting Started, Conventions and more, please visit [Dockerized PHP CLI README.md](https://github.com/fonil/dockerized-php-cli#readme)

## Getting Started

Just clone the repository into your preferred path:

```bash
$ mkdir -p ~/path/to/my-new-project && cd ~/path/to/my-new-project
$ git clone git@github.com:alcidesrc/zenrows-web-scraping-with-php.git .
```

### Commands

#### Build the service

```bash
~/path/to/my-new-project$ make build

[+] Building 39.6s (15/15) FINISHED
 => [internal] load build definition from Dockerfile                                                                      0.0s
 => => transferring dockerfile: 864B                                                                                      0.0s
 => [internal] load .dockerignore                                                                                         0.0s
 => => transferring context: 2B                                                                                           0.0s
 => resolve image config for docker.io/docker/dockerfile:1                                                                2.2s
 => docker-image://docker.io/docker/dockerfile:1@sha256:39b85bbfa7536a5feceb7372a0817649ecb2724562a38360f4d6a7782a409b14  1.2s
 => => resolve docker.io/docker/dockerfile:1@sha256:39b85bbfa7536a5feceb7372a0817649ecb2724562a38360f4d6a7782a409b14      0.0s
 ...
 => exporting to image                                                                                                    0.2s
 => => exporting layers                                                                                                   0.1s
 => => writing image sha256:4db3a759484c817883a6c2dc6f9d747f5284b2f59b758375ac2e8cb6e10f7571                              0.0s
 => => naming to docker.io/library/zenrows-web-scrapping-with-php-app                                                     0.0s

 ✅  Task done!
```

#### Start the service

```bash
~/path/to/my-new-project$ make up

[+] Running 2/2
 ⠿ Network zenrows-web-scrapping-with-php_default  Created                                                                0.1s
 ⠿ Container zenrows-web-scrapping-with-php-app-1  Started                                                                0.5s

 ✅  Task done!
```

#### Install the dependencies

```bash
~/path/to/my-new-project$ make composer-install

[12.7MiB/0.07s] Installing dependencies from lock file (including require-dev)
[13.2MiB/0.08s] Verifying lock file contents can be installed on current platform.
[13.4MiB/0.08s] Warning: The lock file is not up to date with the latest changes in composer.json. You may be getting outdated dependencies. It is recommended that you run `composer update` or `composer update <package name>`.
[15.1MiB/0.10s] Package operations: 96 installs, 0 updates, 0 removals
[15.2MiB/0.11s]   - Downloading infection/extension-installer (0.1.2)
[15.3MiB/0.11s]   - Downloading squizlabs/php_codesniffer (3.7.2)
...
[20.7MiB/4.32s]   - Installing symfony/css-selector (v6.3.0): Extracting archive
[20.7MiB/4.32s]   - Installing voku/simple_html_dom (4.8.8): Extracting archive
[16.9MiB/5.52s] Generating optimized autoload files
[18.2MiB/7.16s] 71 packages you are using are looking for funding.
[18.2MiB/7.16s] Use the `composer fund` command to find out more!
[18.2MiB/7.16s] Memory usage: 18.24MiB (peak: 38.34MiB), time: 7.16s

 ✅  Task done!
```

#### Executing the application

```bash
~/path/to/my-new-project$ make run concurrency=12

- Scrapping [ https://scrapeme.live/shop/ ] with [ 12 ] concurrent requests...
- Elapsed time: 00:00:18.2594
- Consumed memory: 1.94 MB
- CSV generated at: /output/scrapeme-live-shop.csv

 ✅  Task done!
```

#### Executing the test suite

```bash
~/path/to/my-new-project$ make phpunit

PHPUnit 9.6.8 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.1.19 with PCOV 1.0.11
Configuration: /code/phpunit.xml
Random Seed:   1686218934

..............                                                    14 / 14 (100%)

Time: 00:17.837, Memory: 16.00 MB

OK (14 tests, 19 assertions)

Generating code coverage report in HTML format ... done [00:00.030]


Code Coverage Report:
  2023-06-08 10:09:12

 Summary:
  Classes: 100.00% (4/4)
  Methods: 100.00% (7/7)
  Lines:   100.00% (57/57)

App\Cli\Scrapper
  Methods: 100.00% ( 3/ 3)   Lines: 100.00% ( 38/ 38)
App\FileSystem\CsvFile
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  7/  7)
App\Helpers
  Methods: 100.00% ( 2/ 2)   Lines: 100.00% ( 11/ 11)
App\Http\UserAgents
  Methods: 100.00% ( 1/ 1)   Lines: 100.00% (  1/  1)

Generating code coverage report in PHPUnit XML format ... done [00:00.024]

 ✅  Task done!
```

#### Stop the service

```bash
~/path/to/my-new-project$ make down

[+] Running 2/2
 ⠿ Container zenrows-web-scrapping-with-php-app-1  Removed                                                                0.4s
 ⠿ Network zenrows-web-scrapping-with-php_default  Removed                                                                0.4s

 ✅  Task done!
```

### Stats

#### Environment

|                     | Detail | Description                         |
| ------------------- | ------ | ----------------------------------- |
| Laptop              | Model  | Dell XPS 9315 (x86_64)              |
|                     | OS     | Ubuntu 20.04.1                      |
|                     | CPU    | 12th Gen Intel(R) Core(TM) i7-1250U |
|                     | RAM    | 16 Gb                               |
| Internet Connection | Type   | Optic fiber                         |

> For further details about Internet Connection, please visit the [SpeedTest report](https://www.speedtest.net/result/14840527156)

#### Results

| Concurrency Level | Consumed Memory | Elapsed Time  |
| ----------------- | --------------- | ------------- |
| 1                 | 1.93 MB         | 00:01:25.3453 |
| 2                 | 1.93 MB         | 00:00:42.659  |
| 3                 | 1.93 MB         | 00:00:38.2379 |
| 5                 | 1.93 MB         | 00:00:24.7107 |
| 13                | 1.93 MB         | 00:00:16.7150 |

## Security Vulnerabilities

PLEASE DON'T DISCLOSE SECURITY-RELATED ISSUES PUBLICLY

## Supported Versions

Only the latest major version receives security fixes.

## License

The MIT License (MIT). Please see [LICENSE](./LICENSE) file for more information.
