<?php

namespace Orkhanahmadov\Currencylayer\Tests\Data;

use Orkhanahmadov\Currencylayer\Data\Change;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class ChangeTest extends TestCase
{
    /**
     * @var Change
     */
    private $class;

    public function testGetSource()
    {
        $this->assertSame('USD', $this->class->source());
    }

    public function testGetQuotes()
    {
        $this->assertTrue(is_array($this->class->quotes()));
        $this->assertCount(3, $this->class->quotes());
    }

    public function testGetStartDate()
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $this->class->startDate());
        $this->assertSame('2005-01-01', $this->class->startDate()->format('Y-m-d'));
    }

    public function testGetEndDate()
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $this->class->endDate());
        $this->assertSame('2010-01-01', $this->class->endDate()->format('Y-m-d'));
    }

    public function testStartRate()
    {
        $this->assertSame(0.73618, $this->class->startRate('EUR'));
    }

    public function testEndRate()
    {
        $this->assertSame(1.108609, $this->class->endRate('AUD'));
    }

    public function testChangeAmount()
    {
        $this->assertSame(1.9594, $this->class->amount('MXN'));
    }

    public function testChangePercentage()
    {
        $this->assertSame(-5.2877, $this->class->percentage('EUR'));
    }

    public function testThrowsExceptionIfCurrencyKeyIsNotAvailable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ABC currency is not available. Did you put it in request?');

        $this->class->startRate('ABC');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Change(json_decode($this->jsonFixture('change'), true));
    }
}
