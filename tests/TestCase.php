<?php

namespace Orkhanahmadov\Currencylayer\Tests;

use PHPUnit\Framework\TestCase as PHPUnit;

abstract class TestCase extends PHPUnit
{
    const API_HTTP_URL = 'http://apilayer.net/api/';
    const API_HTTPS_URL = 'https://apilayer.net/api/';
    const FAKE_ACCESS_KEY = 'whatever';

    protected function jsonFixture(string $fileName)
    {
        return file_get_contents(__DIR__ . '/__fixtures__/' . $fileName . '.json');
    }
}
