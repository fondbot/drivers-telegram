<?php

declare(strict_types=1);

namespace Tests;

use Mockery;
use Faker\Factory;
use Faker\Generator;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use FondBot\Drivers\Telegram\Type;
use GuzzleHttp\Handler\MockHandler;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
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

    protected function guzzle(Response ...$responses): Client
    {
        $mock = new MockHandler($responses);

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }

    protected function assertSameType($expected, $actual)
    {
        $this->assertSame(get_class($expected), get_class($actual));

        collect(get_class_methods($actual))
            ->filter(function (string $name) {
                return starts_with($name, 'get');
            })
            ->each(function (string $method) use ($actual, $expected) {
                $expected = $expected->$method();
                $actual = $actual->$method();

                if ($expected instanceof Type) {
                    $this->assertSameType($expected, $actual);
                } else {
                    $this->assertSame($expected, $actual);
                }
            });

        $this->assertEquals($expected, $actual);
    }
}
