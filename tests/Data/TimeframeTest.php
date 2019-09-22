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

    protected function setUp(): void
    {
        parent::setUp();

        $this->class = new Timeframe(json_decode($this->jsonFixture('timeframe'), true));
    }
}
