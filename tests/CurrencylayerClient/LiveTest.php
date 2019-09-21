<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use BlastCloud\Guzzler\UsesGuzzler;
use Carbon\CarbonImmutable;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Currency;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class LiveTest extends TestCase
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
            ->get(self::API_HTTP_URL . 'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source' => 'USD',
                'currencies' => 'EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('live/single')));

        $data = $this->client->source('USD')->currencies('EUR')->live();

        $this->assertInstanceOf(Currency::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(1, $data->getQuotes());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getTimestamp());
        $this->assertSame(1.278342, $data->EUR);
    }

    public function testWithMultipleCurrencies()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL . 'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source' => 'USD',
                'currencies' => 'EUR,AUD',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('live/multiple')));

        $data = $this->client->source('USD')->currencies(['EUR', 'AUD'])->live();

        $this->assertInstanceOf(Currency::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(2, $data->getQuotes());
        $this->assertInstanceOf(CarbonImmutable::class, $data->getTimestamp());
        $this->assertSame(1.278342, $data->EUR);
        $this->assertSame(1.269072, $data->AUD);
    }
}
