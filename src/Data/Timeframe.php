<?php

namespace Orkhanahmadov\Currencylayer\Data;

use Carbon\CarbonImmutable;

class Timeframe
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
     * Timeframe constructor.
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

    /**
     * @param \DateTimeImmutable|string $date
     *
     * @throws \Exception
     *
     * @return array
     */
    public function for($date): array
    {
        $date = $date instanceof \DateTimeImmutable ?
            $date->format('Y-m-d') :
            (new CarbonImmutable($date))->format('Y-m-d');

        if (!isset($this->quotes[$date])) {
            throw new \InvalidArgumentException(
                "Quotes for {$date} is not available. Did you put it in request?"
            );
        }

        return $this->quotes[$date];
    }

    /**
     * @param string $name
     * @param $arguments
     *
     * @return float
     */
    public function __call(string $name, $arguments): float
    {
        if (!isset($arguments[0])) {
            throw new \InvalidArgumentException(
                "{$name} method doesn't exist."
            );
        }

        $key = $this->source.$name;
        if (!isset($this->quotes[$arguments[0]]) || !isset($this->quotes[$arguments[0]][$key])) {
            throw new \InvalidArgumentException(
                "{$this->source} -> {$name} quotes for {$arguments[0]} is not available. Did you put it in request?"
            );
        }

        return $this->quotes[$arguments[0]][$key];
    }
}
