<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class HistoricalTest extends TestCase
{
    public function testWithSingleCurrency()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'historical')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'date'       => '2005-02-01',
                'source'     => 'USD',
                'currencies' => 'AED',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('historical/single')));

        $data = $this->client->source('USD')->currency('AED')->date('2005-02-01')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->source());
        $this->assertCount(1, $data->quotes());
        $this->assertSame(1107302399, $data->timestamp());
        $this->assertSame('2005-02-01', $data->date()->format('Y-m-d'));
        $this->assertSame(3.67266, $data->AED);
    }

    public function testWithMultipleCurrencies()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'historical')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'date'       => '2005-02-01',
                'source'     => 'USD',
                'currencies' => 'AED,ALL',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('historical/multiple')));

        $data = $this->client->source('USD')->currency('AED', 'ALL')->date('2005-02-01')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->source());
        $this->assertCount(2, $data->quotes());
        $this->assertSame(1107302399, $data->timestamp());
        $this->assertSame('2005-02-01', $data->date()->format('Y-m-d'));
        $this->assertSame(3.67266, $data->AED);
        $this->assertSame(96.848753, $data->ALL);
    }

    public function testWithDateTimeInterface()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'historical')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'date'       => '2005-02-01',
                'source'     => 'USD',
                'currencies' => 'AED',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('historical/single')));

        $data = $this->client->source('USD')->currency('AED')->date(new \DateTimeImmutable('2005-02-01'))->quotes();

        $this->assertSame('2005-02-01', $data->date()->format('Y-m-d'));
    }
}
