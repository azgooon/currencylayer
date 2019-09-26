<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class LiveTest extends TestCase
{
    public function testWithSingleCurrency()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source'     => 'USD',
                'currencies' => 'EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('live/single')));

        $data = $this->client->source('USD')->currency('EUR')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->source());
        $this->assertCount(1, $data->quotes());
        $this->assertSame(1432400348, $data->timestamp());
        $this->assertSame(1.278342, $data->EUR);
    }

    public function testWithMultipleCurrencies()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source'     => 'USD',
                'currencies' => 'EUR,AUD',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('live/multiple')));

        $data = $this->client->source('USD')->currency('EUR', 'AUD')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->source());
        $this->assertCount(2, $data->quotes());
        $this->assertSame(1432400348, $data->timestamp());
        $this->assertSame(1.278342, $data->EUR);
        $this->assertSame(1.269072, $data->AUD);
    }
}
