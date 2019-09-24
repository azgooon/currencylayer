<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use Orkhanahmadov\Currencylayer\Data\Timeframe;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class TimeframeTest extends TestCase
{
    use UsesGuzzler;

    /**
     * @var CurrencylayerClient
     */
    private $client;

    public function test()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'timeframe')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'start_date' => '2010-03-01',
                'end_date'   => '2010-03-02',
                'source'     => 'USD',
                'currencies' => 'GBP,EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('timeframe')));

        $data = $this->client->source('USD')->currency(['GBP', 'EUR'])->timeframe('2010-03-01', '2010-03-02');

        $this->assertInstanceOf(Timeframe::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(2, $data->getQuotes());
        $this->assertSame(0.668525, $data->GBP('2010-03-01'));
        $this->assertSame(0.736145, $data->EUR('2010-03-02'));
        $this->assertCount(2, $data->quotes('2010-03-01'));
        $this->assertSame('2010-03-01', $data->getStartDate()->format('Y-m-d'));
        $this->assertSame('2010-03-02', $data->getEndDate()->format('Y-m-d'));
    }

    public function testWithDateTimeInterface()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'timeframe')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'start_date' => '2010-03-01',
                'end_date'   => '2010-03-02',
                'source'     => 'USD',
                'currencies' => 'GBP,EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('timeframe')));

        $data = $this->client->source('USD')->currency(['GBP', 'EUR'])
            ->timeframe(new \DateTimeImmutable('2010-03-01'), new \DateTimeImmutable('2010-03-02'));

        $this->assertSame('2010-03-01', $data->getStartDate()->format('Y-m-d'));
        $this->assertSame('2010-03-02', $data->getEndDate()->format('Y-m-d'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new CurrencylayerClient(self::FAKE_ACCESS_KEY);
        $this->client->setClient($this->guzzler->getClient(['base_uri' => self::API_HTTP_URL]));
    }
}
