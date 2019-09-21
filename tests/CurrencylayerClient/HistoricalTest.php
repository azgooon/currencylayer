<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use BlastCloud\Guzzler\UsesGuzzler;
use Carbon\CarbonImmutable;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class HistoricalTest extends TestCase
{
    use UsesGuzzler;

    /**
     * @var CurrencylayerClient
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new CurrencylayerClient(self::FAKE_ACCESS_KEY);
        $this->client->setClient($this->guzzler->getClient(['base_uri' => self::API_HTTP_URL]));
    }

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

        $data = $this->client->source('USD')->currencies('AED')->date('2005-02-01')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(1, $data->getQuotes());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getTimestamp());
        $this->assertSame(1107302399, $data->getTimestamp()->unix());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getDate());
        $this->assertSame('2005-02-01', $data->getDate()->format('Y-m-d'));
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

        $data = $this->client->source('USD')->currencies(['AED', 'ALL'])->date('2005-02-01')->quotes();

        $this->assertInstanceOf(Quotes::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(2, $data->getQuotes());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getTimestamp());
        $this->assertSame(1107302399, $data->getTimestamp()->unix());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getDate());
        $this->assertSame('2005-02-01', $data->getDate()->format('Y-m-d'));
        $this->assertSame(3.67266, $data->AED);
        $this->assertSame(96.848753, $data->ALL);
    }
}
