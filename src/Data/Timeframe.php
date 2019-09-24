<?php

namespace Orkhanahmadov\Currencylayer\Data;

class Timeframe
{
    /**
     * @var string
     */
    private $source;
    /**
     * @var \DateTimeInterface
     */
    private $startDate;
    /**
     * @var \DateTimeInterface
     */
    private $endDate;
    /**
     * @var array
     */
    private $quotes;

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
        $this->startDate = new \DateTimeImmutable($data['start_date']);
        $this->endDate = new \DateTimeImmutable($data['end_date']);
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @return array
     */
    public function getQuotes(): array
    {
        return $this->quotes;
    }

    /**
     * @param \DateTimeInterface|string $date
     *
     * @throws \Exception
     *
     * @return array
     */
    public function quotes($date): array
    {
        $date = $date instanceof \DateTimeInterface ?
            $date->format('Y-m-d') :
            (new \DateTimeImmutable($date))->format('Y-m-d');

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
        if (isset($arguments[0])) {
            $date = $arguments[0] instanceof \DateTimeInterface ?
                $arguments[0]->format('Y-m-d') :
                $arguments[0];
        }

        $key = $this->source.$name;
        if (!isset($date) || !isset($this->quotes[$date]) || !isset($this->quotes[$date][$key])) {
            throw new \InvalidArgumentException(
                "{$name} currency or its argument is invalid. You sure you calling correct currency with correct date?"
            );
        }

        return $this->quotes[$date][$key];
    }
}
