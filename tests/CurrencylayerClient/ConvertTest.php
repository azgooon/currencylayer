<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class ConvertTest extends TestCase
{
    public function testConvertWithLiveQuotes()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'convert')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'from'       => 'USD',
                'to'         => 'GBP',
                'amount'     => 10,
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('convert/live')));

        $data = $this->client->source('USD')->currency('GBP')->convert(10);

        $this->assertInstanceOf(Conversion::class, $data);
        $this->assertSame('USD', $data->fromCurrency());
        $this->assertSame('GBP', $data->toCurrency());
        $this->assertSame(10, $data->amount());
        $this->assertSame(1430068515, $data->timestamp());
        $this->assertSame(0.658443, $data->quote());
        $this->assertSame(6.58443, $data->result());
    }

    public function testConvertWithSpecificDateQuotes()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'convert')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'date'       => '2005-01-01',
                'from'       => 'USD',
                'to'         => 'GBP',
                'amount'     => 10,
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('convert/historical')));

        $data = $this->client->source('USD')->currency('GBP')->date('2005-01-01')->convert(10);

        $this->assertInstanceOf(Conversion::class, $data);
        $this->assertSame('USD', $data->fromCurrency());
        $this->assertSame('GBP', $data->toCurrency());
        $this->assertSame(10, $data->amount());
        $this->assertSame(1104623999, $data->timestamp());
        $this->assertSame(0.51961, $data->quote());
        $this->assertSame(5.1961, $data->result());
        $this->assertSame('2005-01-01', $data->date()->format('Y-m-d'));
    }

    public function testThrowsExceptionIfFromOrToCurrenciesNotAvailable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Conversion "from" and "to" currencies were not set.');

        $this->client->convert(123);
    }
}
