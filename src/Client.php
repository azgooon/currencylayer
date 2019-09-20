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
     * @return array
     */
    public function live(): array;

//    public function date($currencies): self;
//
//    public function historical(): array;
//
//    public function convert(float $amount, string $fromCurrency, string $toCurrency);
//
//    public function currencies(): array;
}
