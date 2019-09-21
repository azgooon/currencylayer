<?php

namespace Orkhanahmadov\Currencylayer;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use GuzzleHttp\Client as Guzzle;
use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Data\Quotes;

class CurrencylayerClient implements Client
{
    /**
     * @var Guzzle
     */
    private $client;
    /**
     * @var string
     */
    private $accessKey;
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $currencies;
    /**
     * @var DateTimeImmutable
     */
    private $date;

    /**
     * CurrencylayerClient constructor.
     *
     * @param string $accessKey
     * @param bool $useHttps
     */
    public function __construct(string $accessKey, bool $useHttps = false)
    {
        $this->client = new Guzzle([
            'base_uri' => $useHttps ? 'https://apilayer.net/api/' : 'http://apilayer.net/api/'
        ]);

        $this->accessKey = $accessKey;
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function source(string $source): Client
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param array<string>|string $currencies
     *
     * @return $this
     */
    public function currencies($currencies): Client
    {
        if (is_array($currencies)) {
            $this->currencies = implode(',', $currencies);
        } else {
            $this->currencies = $currencies;
        }

        return $this;
    }

    /**
     * @param DateTimeImmutable|string $date
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function date($date): Client
    {
        $this->date = $date instanceof DateTimeImmutable ? $date : new CarbonImmutable($date);

        return $this;
    }

    /**
     * @return Quotes
     *
     * @throws \Exception
     */
    public function quotes(): Quotes
    {
        $query = [
            'currencies' => $this->currencies,
            'source' => $this->source,
        ];

        if ($this->date) {
            $query['date'] = $this->date->format('Y-m-d');

            return new Quotes($this->request('historical', $query));
        }

        return new Quotes($this->request('live', $query));
    }

    /**
     * @param int|float $amount
     *
     * @return Conversion
     *
     * @throws \Exception
     */
    public function convert($amount): Conversion
    {
        $query = [
            'from' => $this->source,
            'to' => $this->currencies,
            'amount' => $amount,
        ];

        if ($this->date) {
            $query['date'] = $this->date->format('Y-m-d');
        }

        return new Conversion($this->request('convert', $query));
    }

    /**
     *
     *
     * @param string $endpoint
     * @param array $query
     *
     * @return array
     */
    private function request(string $endpoint, array $query): array
    {
        $response = $this->client->get($endpoint, [
            'query' => array_merge($query, ['access_key' => $this->accessKey]),
        ]);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        if (! $data['success']) {
            throw new \InvalidArgumentException($data['error']['info']);
        }

        return $data;
    }

    /**
     * @param Guzzle $client
     */
    public function setClient(Guzzle $client): void
    {
        $this->client = $client;
    }
}
