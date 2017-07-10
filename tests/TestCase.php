<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client;
use Mockery;
use Faker\Factory;
use Faker\Generator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    private $guzzle;

    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    protected function faker(): Generator
    {
        return Factory::create();
    }

    /**
     * @param string $class
     *
     * @return \Mockery\Mock|mixed
     */
    protected function mock(string $class)
    {
        return Mockery::mock($class);
    }

    protected function guzzle() {
        return $this->guzzle ?? $this->mock(Client::class);
    }
}
