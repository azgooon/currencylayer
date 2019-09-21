<?php

namespace Orkhanahmadov\Currencylayer;

use Carbon\CarbonImmutable;
use DateTimeImmutable;

class Conversion
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    /**
     * @var int|float
     */
    private $amount;
    /**
     * @var CarbonImmutable
     */
    private $timestamp;
    /**
     * @var float
     */
    private $quote;
    /**
     * @var float
     */
    private $result;

    /**
     * Conversion constructor.
     *
     * @param array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        $this->from = $data['query']['from'];
        $this->to = $data['query']['to'];
        $this->amount = $data['query']['amount'];
        $this->quote = $data['info']['quote'];
        $this->result = $data['result'];
        $this->timestamp = new CarbonImmutable($data['info']['timestamp']);
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getTimestamp(): DateTimeImmutable
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function getQuote(): float
    {
        return $this->quote;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return $this->result;
    }
}
