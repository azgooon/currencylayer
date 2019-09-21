<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use BlastCloud\Guzzler\UsesGuzzler;
use Carbon\CarbonImmutable;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use Orkhanahmadov\Currencylayer\Data\Timeframe;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class ChangeTest extends TestCase
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
            ->get(self::API_HTTP_URL.'change')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'start_date' => '2005-01-01',
                'end_date'   => '2010-01-01',
                'source'     => 'USD',
                'currencies' => 'AUD,EUR,MXN',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('timeframe')));

        $data = $this->client->source('USD')
            ->currencies('AUD,EUR,MXN')
            ->startDate('2005-01-01')
            ->endDate('2010-01-01')
            ->change();

        $this->assertInstanceOf(Change::class, $data);
        $this->assertSame('USD', $data->getSource());
        $this->assertCount(3, $data->getQuotes());
        $this->assertSame(1.281236, $data->startRate('AUD'));
        $this->assertSame(1.108609, $data->endRate('AUD'));
        $this->assertSame(-0.1726, $data->change('AUD'));
        $this->assertSame(-13.4735, $data->changePercentage('AUD'));
        $this->assertSame(11.149362, $data->startRate('MXN'));
        $this->assertSame(13.108757, $data->endRate('MXN'));
        $this->assertSame(1.9594, $data->change('MXN'));
        $this->assertSame(17.5741, $data->changePercentage('MXN'));
        $this->assertInstanceOf(CarbonImmutable::class, $data->getStartDate());
        $this->assertSame('2005-01-01', $data->getStartDate()->format('Y-m-d'));
        $this->assertInstanceOf(CarbonImmutable::class, $data->getEndDate());
        $this->assertSame('2010-01-01', $data->getEndDate()->format('Y-m-d'));
    }
}
