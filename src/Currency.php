<?php

namespace Orkhanahmadov\Currencylayer;

use Carbon\CarbonImmutable;
use DateTimeImmutable;

class Currency
{
    /**
     * @var array
     */
    private $quotes;
    /**
     * @var string
     */
    private $source;
    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var string|null
     */
    private $date;

    /**
     * Currency constructor.
     *
     * @param array $quotes
     * @param string $source
     * @param int $timestamp
     * @param string|null $date
     */
    public function __construct(array $quotes, string $source, int $timestamp, ?string $date = null)
    {
        $this->quotes = $quotes;
        $this->source = $source;
        $this->timestamp = $timestamp;
        $this->date = $date;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        $key = $this->source . $name;
        if (! array_key_exists($key, $this->quotes)) {
            throw new \InvalidArgumentException($name . ' does not exist in API response. Did you requested it?');
        }

        return $this->quotes[$key];
    }

    /**
     * @return array
     */
    public function getQuotes(): array
    {
        return $this->quotes;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return DateTimeImmutable
     * @throws \Exception
     */
    public function getTimestamp(): DateTimeImmutable
    {
        return new CarbonImmutable($this->timestamp);
    }
}
