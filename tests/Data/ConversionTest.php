<?php

namespace Orkhanahmadov\Currencylayer\Tests\Data;

use Orkhanahmadov\Currencylayer\Data\Conversion;
use Orkhanahmadov\Currencylayer\Tests\TestCase;

class ConversionTest extends TestCase
{
    /**
     * @var Conversion
     */
    private $class;

    public function testGetFromCurrency()
    {
        $this->assertSame('USD', $this->class->fromCurrency());
    }

    public function testGetToCurrency()
    {
        $this->assertSame('GBP', $this->class->toCurrency());
    }

    public function testGetDate()
    {
        $class = new Conversion(json_decode($this->jsonFixture('convert/historical'), true));

        $this->assertInstanceOf(\DateTimeInterface::class, $class->date());
        $this->assertSame('2005-01-01', $class->date()->format('Y-m-d'));
    }

    public function testGetDateWithNull()
    {
        $this->assertNull($this->class->date());
    }

    public function testGetAmount()
    {
        $this->assertSame(10, $this->class->amount());
    }

    public function testGetTimestamp()
    {
        $this->assertSame(1430068515, $this->class->timestamp());
    }

    public function testGetQuote()
    {
        $this->assertSame(0.658443, $this->class->quote());
    }

    public function testGetResult()
    {
        $this->assertSame(6.58443, $this->class->result());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Conversion(json_decode($this->jsonFixture('convert/live'), true));
    }
}
