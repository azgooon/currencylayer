<?php

namespace Orkhanahmadov\Currencylayer;

use Orkhanahmadov\Currencylayer\Data\Change;
use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Data\Timeframe;

interface Client
{
    /**
     * @param string $sourceCurrency
     *
     * @return $this
     */
    public function source(string $sourceCurrency): self;

    /**
     * @param array<string>|string $currency
     *
     * @return $this
     */
    public function currency($currency): self;

    /**
     * @param \DateTimeInterface|string $date
     *
     * @return $this
     */
    public function date($date): self;

    /**
     * @return Quotes
     */
    public function quotes(): Quotes;

    /**
     * @param int|float $amount
     *
     * @return Conversion
     */
    public function convert($amount): Conversion;

    /**
     * @param \DateTimeInterface|string $startDate
     * @param \DateTimeInterface|string $endDate
     *
     * @return Timeframe
     */
    public function timeframe($startDate, $endDate): Timeframe;

    /**
     * @param \DateTimeInterface|string $startDate
     * @param \DateTimeInterface|string $endDate
     *
     * @return Change
     */
    public function change($startDate, $endDate): Change;

    /**
     * @return array
     */
    public function list(): array;
}
