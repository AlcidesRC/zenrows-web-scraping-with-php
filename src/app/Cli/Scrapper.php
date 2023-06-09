<?php

declare(strict_types=1);

namespace App\Cli;

use App\Http\UserAgents;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use voku\helper\HtmlDomParser;

final class Scrapper
{
    private Client $client;
    private int $concurrency;

    /**
     * @var array<int|string, mixed>
     */
    private array $result;

    /**
     * @param array<string, array<int, int>|int|string> $config
     */
    public function setup(array $config): self
    {
        $this->client      = new Client($config['guzzle_client']);  // @phpstan-ignore-line
        $this->concurrency = $config['concurrency'];                // @phpstan-ignore-line
        $this->result      = [];

        return $this;
    }

    /**
     * @return array{int, array{string, string, string, string}}
     */
    public function processWholeShopWithConcurrency(): array
    {
        $requestsGenerator = function () {
            $maxPage = $this->getMaxPage();

            foreach (range(1, $maxPage) as $page) {
                yield new Request('GET', "page/$page", [
                    RequestOptions::HEADERS => ['User-Agent' => UserAgents::getRandom()],
                ]);
            }
        };

        $pool = new Pool($this->client, $requestsGenerator(), [
            'concurrency' => $this->concurrency,

            'fulfilled' => function (Response $response): void {
                $parser = HtmlDomParser::str_get_html($response->getBody()->getContents());

                $items = array_map(static function ($item) {
                    return [
                        $item->findOne('a')->getAttribute('href'),
                        $item->findOne('img')->getAttribute('src'),
                        $item->findOne('h2')->text,
                        $item->findOne('.price span')->text,
                    ];
                }, (array) $parser->find('li.product'));

                $this->result = [...$this->result, ...$items];
            },

            'rejected' => function (ConnectException|RequestException $e) {
                // TODO - Log possible exceptions
            },
        ]);

        $pool->promise()->wait();

        sort($this->result);

        return $this->result;
    }

    public function getMaxPage(): int
    {
        $response = $this->client->request('GET', 'page/1', [
            RequestOptions::HEADERS => ['User-Agent' => UserAgents::getRandom()],
        ]);

        $parser = HtmlDomParser::str_get_html($response->getBody()->getContents());

        // @phpstan-ignore-next-line
        $links = $parser->find('nav.woocommerce-pagination', 0)->find('ul.page-numbers li a.page-numbers')->text;

        return (int) max((array) $links);
    }
}
