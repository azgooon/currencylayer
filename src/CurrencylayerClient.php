<?php

namespace Orkhanahmadov\Currencylayer;

use Carbon\CarbonImmutable;
use DateTimeImmutable;
use GuzzleHttp\Client as Guzzle;

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
     * @return Currency
     *
     * @throws \Exception
     */
    public function live(): Currency
    {
        $data = $this->request('live', [
            'currencies' => $this->currencies,
            'source' => $this->source,
        ]);

        return new Currency($data);
    }

    /**
     * @return Currency
     *
     * @throws \Exception
     */
    public function historical(): Currency
    {
        $data = $this->request('historical', [
            'date' => $this->date->format('Y-m-d'),
            'currencies' => $this->currencies,
            'source' => $this->source,
        ]);

        return new Currency($data);
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

        $response = $this->request('convert', [
            'date' => $this->date ? $this->date->format('Y-m-d') : null,
            'from' => $this->source,
            'to' => $this->currencies,
            'amount' => $amount,
        ]);

        return new Conversion($response);
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
