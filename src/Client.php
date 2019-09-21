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
     * @param array<string>|string $currencies
     *
     * @return $this
     */
    public function currencies($currencies): self;

    /**
     * @param \DateTimeImmutable|string $date
     *
     * @return $this
     */
    public function date($date): self;

    /**
     * @param \DateTimeImmutable|string $date
     *
     * @return $this
     */
    public function startDate($date): self;

    /**
     * @param \DateTimeImmutable|string $date
     *
     * @return $this
     */
    public function endDate($date): self;

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
     * @return Timeframe
     */
    public function timeframe(): Timeframe;

    /**
     * @return Change
     */
    public function change(): Change;
}
