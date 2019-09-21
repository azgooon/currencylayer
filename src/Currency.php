<?php

namespace Orkhanahmadov\Currencylayer;

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

    public function __construct(array $quotes, string $source, int $timestamp, ?string $date = null)
    {
        $this->quotes = $quotes;
        $this->source = $source;
        $this->timestamp = $timestamp;
        $this->date = $date;
    }
}
