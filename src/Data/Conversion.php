<?php

namespace Orkhanahmadov\Currencylayer\Data;

use Carbon\CarbonImmutable;

class Conversion
{
    /**
     * @var string
     */
    private $fromCurrency;
    /**
     * @var string
     */
    private $toCurrency;
    /**
     * @var \DateTimeImmutable|null
     */
    private $date = null;
    /**
     * @var int|float
     */
    private $amount;
    /**
     * @var int
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
     *
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        $this->fromCurrency = $data['query']['from'];
        $this->toCurrency = $data['query']['to'];
        $this->amount = $data['query']['amount'];
        $this->quote = $data['info']['quote'];
        $this->result = $data['result'];
        $this->timestamp = $data['info']['timestamp'];
        $this->date = isset($data['date']) ? new CarbonImmutable($data['date']) : null;
    }

    /**
     * @return string
     */
    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    /**
     * @return string
     */
    public function getToCurrency(): string
    {
        return $this->toCurrency;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return float|int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
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
