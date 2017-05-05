<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Commands;

use FondBot\Contracts\Arrayable;
use FondBot\Drivers\Commands\SendRequest;

class SendRequestAdapter implements Arrayable
{
    private $command;

    public function __construct(SendRequest $command)
    {
        $this->command = $command;
    }

    public function getEndpoint(): string
    {
        return $this->command->endpoint;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->command->parameters;
    }
}
