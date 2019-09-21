<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\CurrencylayerClient;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class RequestTest extends TestCase
{
    use UsesGuzzler;

    public function testSendsHttpsRequest()
    {
        $client = new CurrencylayerClient(self::FAKE_ACCESS_KEY, true);
        $client->setClient($this->guzzler->getClient(['base_uri' => self::API_HTTPS_URL]));

        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTPS_URL.'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source'     => 'USD',
                'currencies' => 'EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('live/single')));

        $client->source('USD')->currencies('EUR')->quotes();
    }

    public function testThrowsExceptionIfAPIRequestsNonSuccessfulResponse()
    {
        $client = new CurrencylayerClient(self::FAKE_ACCESS_KEY);
        $client->setClient($this->guzzler->getClient(['base_uri' => self::API_HTTP_URL]));

        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'live')
            ->withQuery([
                'access_key' => self::FAKE_ACCESS_KEY,
                'source'     => 'USD',
                'currencies' => 'EUR',
            ])
            ->willRespond(new Response(200, [], $this->jsonFixture('error')));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'You have not supplied a valid API Access Key. [Technical Support: support@apilayer.com]'
        );

        $client->source('USD')->currencies('EUR')->quotes();
    }
}
