<?php

namespace Orkhanahmadov\Currencylayer\Tests\Data;

use Carbon\CarbonImmutable;
use Orkhanahmadov\Currencylayer\Data\Timeframe;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class TimeframeTest extends TestCase
{
    /**
     * @var Timeframe
     */
    private $class;

    public function testGetSource()
    {
        $this->assertSame('USD', $this->class->getSource());
    }

    public function testGetQuotes()
    {
        $this->assertTrue(is_array($this->class->getQuotes()));
        $this->assertCount(2, $this->class->getQuotes());
    }

    public function testGetStartDate()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->class->getStartDate());
        $this->assertSame('2010-03-01', $this->class->getStartDate()->format('Y-m-d'));
    }

    public function testGetEndDate()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->class->getEndDate());
        $this->assertSame('2010-03-02', $this->class->getEndDate()->format('Y-m-d'));
    }

    public function testQuotes()
    {
        $this->assertTrue(is_array($this->class->quotes('2010-03-02')));
    }

    public function testQuotesWithDateTimeImmutable()
    {
        $this->assertTrue(is_array($this->class->quotes(new CarbonImmutable('2010-03-02'))));
    }

    public function testQuotesThrowsExceptionWhenDateIsNotAvailable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Quotes for 2018-03-02 is not available. Did you put it in request?');

        $this->class->quotes('2018-03-02');
    }

    public function testGetsCurrencyRate()
    {
        $this->assertSame(0.668827, $this->class->GBP('2010-03-02'));
    }

    public function testMagicThrowsExceptionIfArgumentIsNotAvailable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'whatever currency or its argument is invalid. You sure you calling correct currency with correct date?'
        );

        $this->class->whatever();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Timeframe(json_decode($this->jsonFixture('timeframe'), true));
    }
}
