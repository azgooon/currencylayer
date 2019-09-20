<?php

namespace Orkhanahmadov\Currencylayer\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Currencylayer\Currencylayer;

class ClientTest extends TestCase
{
    use UsesGuzzler;

    /**
     * @var Currencylayer
     */
    private $currencylayer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currencylayer = new Currencylayer('whatever');
        $this->currencylayer->setClient($this->guzzler->getClient(['base_uri' => self::API_HTTP_URL]));
    }

    public function testLive()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_HTTP_URL . 'live')
            ->willRespond(new Response(200, [], $this->jsonFixture('live')));

        $data = $this->currencylayer->live();
    }
}
