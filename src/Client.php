<?php

namespace Orkhanahmadov\Currencylayer;

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
     * @return Currency
     */
    public function quotes(): Currency;

    /**
     * @param int|float $amount
     *
     * @return Conversion
     */
    public function convert($amount): Conversion;
}
