<?php

namespace Orkhanahmadov\Currencylayer\Tests\CurrencylayerClient;

use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class ListTest extends TestCase
{
    public function test()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL.'list')
            ->withQuery(['access_key' => self::FAKE_ACCESS_KEY])
            ->willRespond(new Response(200, [], $this->jsonFixture('list')));

        $data = $this->client->list();

        $this->assertTrue(is_array($data));
        $this->assertCount(3, $data);
    }
}
