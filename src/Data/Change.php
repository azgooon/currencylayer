<?php

namespace Orkhanahmadov\Currencylayer\Data;

use Carbon\CarbonImmutable;

class Change
{
    /**
     * @var string
     */
    private $source;
    /**
     * @var array
     */
    private $quotes;
    /**
     * @var CarbonImmutable
     */
    private $startDate;
    /**
     * @var CarbonImmutable
     */
    private $endDate;

    /**
     * Change constructor.
     *
     * @param array $data
     *
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        $this->source = $data['source'];
        $this->quotes = $data['quotes'];
        $this->startDate = new CarbonImmutable($data['start_date']);
        $this->endDate = new CarbonImmutable($data['end_date']);
    }

    /**
     * @param string $currency
     *
     * @return float
     */
    public function startRate(string $currency): float
    {
        return $this->quotes[$this->findKey($currency)]['start_rate'];
    }

    /**
     * @param string $currency
     *
     * @return float
     */
    public function endRate(string $currency): float
    {
        return $this->quotes[$this->findKey($currency)]['end_rate'];
    }

    /**
     * @param string $currency
     *
     * @return float
     */
    public function change(string $currency): float
    {
        return $this->quotes[$this->findKey($currency)]['change'];
    }

    /**
     * @param string $currency
     *
     * @return float
     */
    public function changePercentage(string $currency): float
    {
        return $this->quotes[$this->findKey($currency)]['change_pct'];
    }

    /**
     * @param string $currency
     *
     * @return string
     */
    private function findKey(string $currency): string
    {
        $key = $this->source . $currency;
        if (! isset($this->quotes[$key])) {
            throw new \InvalidArgumentException(
                "{$currency} currencies is not available. Did you put it in request?"
            );
        }

        return $key;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function getQuotes(): array
    {
        return $this->quotes;
    }

    /**
     * @return CarbonImmutable
     */
    public function getStartDate(): CarbonImmutable
    {
        return $this->startDate;
    }

    /**
     * @return CarbonImmutable
     */
    public function getEndDate(): CarbonImmutable
    {
        return $this->endDate;
    }
}
