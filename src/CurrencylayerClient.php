<?php

namespace Orkhanahmadov\Currencylayer;

use Carbon\CarbonImmutable;
use GuzzleHttp\Client as Guzzle;
use Orkhanahmadov\Currencylayer\Data\Change;
use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Data\Timeframe;

// todo: list method
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
    private $source = 'USD';
    /**
     * @var string
     */
    private $currencies;
    /**
     * @var \DateTimeInterface|null
     */
    private $date = null;

    /**
     * CurrencylayerClient constructor.
     *
     * @param string $accessKey
     * @param bool   $useHttps
     */
    public function __construct(string $accessKey, bool $useHttps = false)
    {
        $this->client = new Guzzle([
            'base_uri' => $useHttps ? 'https://apilayer.net/api/' : 'http://apilayer.net/api/',
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
     * @param array<string>|string $currency
     *
     * @return $this
     */
    public function currency($currency): Client
    {
        if (is_array($currency)) {
            $this->currencies = implode(',', $currency);
        } else {
            $this->currencies = implode(',', func_get_args());
        }

        return $this;
    }

    /**
     * @param \DateTimeInterface|string $date
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function date($date): Client
    {
        $this->date = $date instanceof \DateTimeInterface ? $date : new CarbonImmutable($date);

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @return Quotes
     */
    public function quotes(): Quotes
    {
        $query = [
            'currencies' => $this->currencies,
            'source'     => $this->source,
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
     * @throws \Exception
     *
     * @return Conversion
     */
    public function convert($amount): Conversion
    {
        if (!$this->source || !$this->currencies) {
            throw new \InvalidArgumentException('Conversion "from" and "to" currencies were not set.');
        }

        $query = [
            'from'   => $this->source,
            'to'     => $this->currencies,
            'amount' => $amount,
        ];

        if ($this->date) {
            $query['date'] = $this->date->format('Y-m-d');
        }

        return new Conversion($this->request('convert', $query));
    }

    /**
     * @throws \Exception
     *
     * @param \DateTimeInterface|string $startDate
     * @param \DateTimeInterface|string $endDate
     *
     * @return Timeframe
     */
    public function timeframe($startDate, $endDate): Timeframe
    {
        $data = $this->request('timeframe', [
            'source'     => $this->source,
            'currencies' => $this->currencies,
            'start_date' => $startDate instanceof \DateTimeInterface ? $startDate->format('Y-m-d') : $startDate,
            'end_date'   => $endDate instanceof \DateTimeInterface ? $endDate->format('Y-m-d') : $endDate,
        ]);

        return new Timeframe($data);
    }

    /**
     * @throws \Exception
     *
     * @param \DateTimeInterface|string $startDate
     * @param \DateTimeInterface|string $endDate
     *
     * @return Change
     */
    public function change($startDate, $endDate): Change
    {
        $data = $this->request('change', [
            'source'     => $this->source,
            'currencies' => $this->currencies,
            'start_date' => $startDate instanceof \DateTimeInterface ? $startDate->format('Y-m-d') : $startDate,
            'end_date'   => $endDate instanceof \DateTimeInterface ? $endDate->format('Y-m-d') : $endDate,
        ]);

        return new Change($data);
    }

    /**
     * @param string $endpoint
     * @param array  $query
     *
     * @return array
     */
    private function request(string $endpoint, array $query): array
    {
        $response = $this->client->get($endpoint, [
            'query' => array_merge($query, ['access_key' => $this->accessKey]),
        ]);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        if (!$data['success']) {
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
