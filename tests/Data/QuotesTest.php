<?php

namespace Orkhanahmadov\Currencylayer\Tests\Data;

use Orkhanahmadov\Currencylayer\Data\Quotes;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class QuotesTest extends TestCase
{
    /**
     * @var Quotes
     */
    private $class;

    public function testGetSource()
    {
        $this->assertSame('USD', $this->class->getSource());
    }

    public function testGetQuotes()
    {
        $class = new Quotes(json_decode($this->jsonFixture('live/multiple'), true));

        $this->assertTrue(is_array($class->getQuotes()));
        $this->assertCount(2, $class->getQuotes());
    }

    public function testGetTimestamp()
    {
        $this->assertSame(1432400348, $this->class->getTimestamp());
    }

    public function testGetDate()
    {
        $class = new Quotes(json_decode($this->jsonFixture('historical/single'), true));

        $this->assertInstanceOf(\DateTimeInterface::class, $class->getDate());
        $this->assertSame('2005-02-01', $class->getDate()->format('Y-m-d'));
    }

    public function testGetDateWithNull()
    {
        $this->assertNull($this->class->getDate());
    }

    public function testGetsCurrencyRate()
    {
        $class = new Quotes(json_decode($this->jsonFixture('live/multiple'), true));

        $this->assertSame(1.269072, $class->AUD);
        $this->assertSame(1.278342, $class->EUR);
    }

    public function testThrowsExceptionIfCurrencyRateIsNotAvailable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ABC does not exist in API response. Did you put it in request?');

        $this->class->ABC;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Quotes(json_decode($this->jsonFixture('live/single'), true));
    }
}
