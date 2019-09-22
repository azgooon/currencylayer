<?php

namespace Orkhanahmadov\Currencylayer\Tests\Data;

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

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Timeframe(json_decode($this->jsonFixture('timeframe'), true));
    }
}
