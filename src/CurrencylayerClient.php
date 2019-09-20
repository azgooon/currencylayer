<?php

namespace Orkhanahmadov\Currencylayer;

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
     * @param array<string> $currencies
     *
     * @return $this
     */
    public function currencies(array $currencies): Client
    {
        $this->currencies = implode(',', $currencies);

        return $this;
    }

    /**
     * @return array
     */
    public function live(): array
    {
        return $this->request('live', [
            'currencies' => $this->currencies,
            'source' => $this->source,
        ]);
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

        if (array_key_exists('error', $data)) {
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
