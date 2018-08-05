<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Drivers\Telegram\TelegramDriver;

class TelegramDriverTest extends TestCase
{
    /** @var TelegramDriver */
    private $driver;

    protected function setUp()
    {
        parent::setUp();

        $this->driver = new TelegramDriver;
    }

    public function testGetName(): void
    {
        $this->assertSame('Telegram', $this->driver->getName());
    }

    public function testGetShortName(): void
    {
        $this->assertSame('telegram', $this->driver->getShortName());
    }
}
