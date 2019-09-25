<?php

namespace Orkhanahmadov\Currencylayer\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use PHPUnit\Framework\TestCase as PHPUnit;

abstract class TestCase extends PHPUnit
{
    use UsesGuzzler;

    const API_HTTP_URL = 'http://apilayer.net/api/';
    const API_HTTPS_URL = 'https://apilayer.net/api/';
    const FAKE_ACCESS_KEY = 'whatever';

    /**
     * @var CurrencylayerClient
     */
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new CurrencylayerClient(self::FAKE_ACCESS_KEY);

        $reflection = new \ReflectionClass(CurrencylayerClient::class);
        $reflectionProp = $reflection->getProperty('client');
        $reflectionProp->setAccessible(true);
        $reflectionProp->setValue($this->client, $this->guzzler->getClient(['base_uri' => self::API_HTTP_URL]));
    }

    protected function jsonFixture(string $fileName): string
    {
        return file_get_contents(__DIR__.'/__fixtures__/'.$fileName.'.json');
    }
}
