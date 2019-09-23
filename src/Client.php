<?php

namespace Orkhanahmadov\Currencylayer;

use Orkhanahmadov\Currencylayer\Data\Change;
use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Data\Timeframe;

interface Client
{
//    /**
//     * @param string $sourceCurrency
//     *
//     * @return $this
//     */
//    public function list(): self;

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
     * @param \DateTimeImmutable|string $date
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
     * @param \DateTimeImmutable|string $startDate
     * @param \DateTimeImmutable|string $endDate
     *
     * @return Timeframe
     */
    public function timeframe($startDate, $endDate): Timeframe;

    /**
     * @param \DateTimeImmutable|string $startDate
     * @param \DateTimeImmutable|string $endDate
     * @return Change
     */
    public function change($startDate, $endDate): Change;
}
