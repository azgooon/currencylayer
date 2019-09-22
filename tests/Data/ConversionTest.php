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
        $this->assertSame('USD', $this->class->getFromCurrency());
    }

    public function testGetToCurrency()
    {
        $this->assertSame('GBP', $this->class->getToCurrency());
    }

    public function testGetDate()
    {
        $class = new Conversion(json_decode($this->jsonFixture('convert/historical'), true));

        $this->assertInstanceOf(\DateTimeImmutable::class, $class->getDate());
        $this->assertSame('2005-01-01', $class->getDate()->format('Y-m-d'));
    }

    public function testGetDateWithNull()
    {
        $this->assertNull($this->class->getDate());
    }

    public function testGetAmount()
    {
        $this->assertSame(10, $this->class->getAmount());
    }

    public function testGetTimestamp()
    {
        $this->assertSame(1430068515, $this->class->getTimestamp());
    }

    public function testGetQuote()
    {
        $this->assertSame(0.658443, $this->class->getQuote());
    }

    public function testGetResult()
    {
        $this->assertSame(6.58443, $this->class->getResult());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Conversion(json_decode($this->jsonFixture('convert/live'), true));
    }
}
