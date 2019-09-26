<?php

namespace Orkhanahmadov\Currencylayer\Data;

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
     * @var \DateTimeInterface|null
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
        $this->date = isset($data['date']) ? new \DateTimeImmutable($data['date']) : null;
    }

    /**
     * @return string
     */
    public function fromCurrency(): string
    {
        return $this->fromCurrency;
    }

    /**
     * @return string
     */
    public function toCurrency(): string
    {
        return $this->toCurrency;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function date(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return float|int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function timestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return float
     */
    public function quote(): float
    {
        return $this->quote;
    }

    /**
     * @return float
     */
    public function result(): float
    {
        return $this->result;
    }
}
